import React, { useState, useEffect } from "react";
import MasterLayout from "../../components/MasterLayout";
import { Table, Space, Button, Modal, message } from "antd";
import axios from "../../utils/config";
import {
    PlusOutlined,
    EditOutlined,
    DeleteOutlined,
    ExclamationCircleOutlined,
    ReloadOutlined,
} from "@ant-design/icons";
import CollectionCreateForm from "./ModalCreate";
import ModalEdit from "./ModalEdit";

const Customer = () => {
    const [state, setState] = useState({
        data: [],
        visible: false,
        loading: false,
        formEdit: false,
        value: {},
    });

    useEffect(() => {
        getCustomers();
    }, []);

    const getCustomers = () => {
        setState({ ...state, loading: true });
        return axios
            .get("/customers", {})
            .then((response) => {
                console.log(response.data.data);
                setState({
                    ...state,
                    data: response.data.data,
                    loading: false,
                });
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const onCreate = (values) => {
        axios
            .post("/customers", { ...values })
            .then((response) => {
                if (response.data.error) {
                    message.error(response.data.error);
                    return false;
                }

                setState({ ...state, visible: false });

                message.success(response.data.message);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const onUpdate = (values) => {
        axios
            .put(`/customers/${values.id}`, { ...values })
            .then((res) => {
                if (res.data.error) {
                    message.error(res.data.error);
                    return false;
                }

                setState({ ...state, formEdit: false });

                message.success(res.data.message);
            })
            .catch((error) => {
                message.error(error);
            });
    };

    const confirm = (id) => {
        Modal.confirm({
            title: "Confirm",
            icon: <ExclamationCircleOutlined />,
            content: "Are you sure remove ?",
            okText: "Delete",
            cancelText: "Cancel",
            onOk: () => {
                axios
                    .delete("/customers/" + id)
                    .then((response) => {
                        message.success(response.data.message);
                        getCustomers();
                    })
                    .catch((error) => {
                        message.error(error);
                    });
            },
        });
    };

    const columns = [
        {
            title: "Name",
            dataIndex: "name",
            key: "name",
            render: (text) => <a>{text}</a>,
        },
        {
            title: "Phone",
            dataIndex: "phone",
            key: "phone",
        },
        {
            title: "Address",
            dataIndex: "address",
            key: "address",
        },
        {
            title: "Action",
            key: "action",
            render: (text, record) => (
                <Space size="middle">
                    <Button
                        size={`small`}
                        icon={<EditOutlined />}
                        onClick={() =>
                            setState({
                                ...state,
                                formEdit: true,
                                value: record,
                            })
                        }
                    />
                    <Button
                        size={`small`}
                        type={`danger`}
                        icon={<DeleteOutlined />}
                        onClick={() => confirm(record.id)}
                    />
                </Space>
            ),
        },
    ];

    const onSelectChange = (selectedRowKeys) => {
        console.log("selectedRowKeys changed: ", selectedRowKeys);
    };

    const rowSelection = {
        onChange: onSelectChange,
    };

    return (
        <MasterLayout>
            <Button
                onClick={() => {
                    setState({ ...state, visible: true });
                }}
            >
                <PlusOutlined /> New
            </Button>

            <Button onClick={getCustomers}>
                <ReloadOutlined /> Relaod
            </Button>

            <div style={{ paddingTop: 5 }} />

            <Table
                loading={state.loading}
                dataSource={state.data}
                columns={columns}
                size={`small`}
                pagination={{ size: "middle", pageSize: 20 }}
                rowSelection={rowSelection}
                rowKey={`id`}
                bordered
            />

            <CollectionCreateForm
                visible={state.visible}
                onCreate={onCreate}
                onCancel={() => {
                    setState({ ...state, visible: false });
                }}
            />

            <ModalEdit
                visible={state.formEdit}
                onCreate={onUpdate}
                onCancel={() => {
                    setState({ ...state, formEdit: false });
                }}
                value={state.value}
            />
        </MasterLayout>
    );
};

export default Customer;
