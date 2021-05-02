import { Modal, Form, Input, Col, Row, Select, Space, Button } from "antd";
import { MinusCircleOutlined, PlusOutlined } from "@ant-design/icons";

const {Option} = Select;

const FormOrder = ({
    visible,
    onCreate,
    onCancel,
    customers,
    products,
    categories,
    services,
}) => {
    const [form] = Form.useForm();

    form.resetFields();

    console.log(customers);
    // console.log(products);
    // console.log(categories);
    // console.log(services);

    return (
        <Modal
            visible={visible}
            title="Create new Order"
            okText="Create"
            cancelText="Cancel"
            onCancel={onCancel}
            onOk={() => {
                form.validateFields()
                    .then((values) => {
                        onCreate(values);
                    })
                    .catch((info) => {
                        console.log("Validate Failed:", info);
                    });
            }}
            width={1000}
        >
            <Form form={form} layout="vertical" name="form_in_modal_order">
                <Row gutter={12}>
                    <Col span={12}>
                        <Form.Item
                            name="name"
                            label="Customer"
                            rules={[
                                {
                                    required: true,
                                    message: "Please input the name !",
                                },
                            ]}
                        >
                            <Select
                                showSearch
                                style={{ width: "100%" }}
                                placeholder="Select Customer"
                                optionFilterProp="children"
                            >
                                {customers != null &&
                                    customers.map((item) => (
                                        <Option key={item.id} value={item.id}>
                                            {item.name}
                                        </Option>
                                    ))}
                            </Select>
                        </Form.Item>
                    </Col>

                    <Col span={12}>
                        <Form.Item
                            name="phone"
                            label="Phone"
                            rules={[
                                {
                                    required: true,
                                    message: "Please input the Phone!",
                                },
                            ]}
                        >
                            <Select
                                showSearch
                                style={{ width: "100%" }}
                                placeholder="Select Phone"
                                optionFilterProp="children"
                            >
                                {customers != null &&
                                    customers.map((item) => (
                                        <Option key={item.id} value={item.id}>
                                            {item.phone}
                                        </Option>
                                    ))}
                            </Select>
                        </Form.Item>
                    </Col>
                </Row>

                <Form.List name="orders">
                    {(fields, { add, remove }) => (
                        <>
                            {fields.map(
                                ({ key, name, fieldKey, ...restField }) => (
                                    <Space
                                        key={key}
                                        style={{
                                            display: "flex",
                                            marginBottom: 8,
                                        }}
                                        align="baseline"
                                    >
                                        <Form.Item
                                            {...restField}
                                            name={[name, "category_id"]}
                                            fieldKey={[fieldKey, "category_id"]}
                                            rules={[
                                                {
                                                    required: true,
                                                    message:
                                                        "require category",
                                                },
                                            ]}
                                        >
                                            <Select
                                                style={{ width: 200 }}
                                                placeholder="Select Category"
                                            >
                                                <Option value="1">Man</Option>
                                                <Option value="2">Man</Option>
                                            </Select>
                                        </Form.Item>

                                        <Form.Item
                                            {...restField}
                                            name={[name, "product_id"]}
                                            fieldKey={[fieldKey, "product_id"]}
                                            rules={[
                                                {
                                                    required: true,
                                                    message: "require product",
                                                },
                                            ]}
                                        >
                                            <Select
                                                style={{ width: 200 }}
                                                placeholder="Select Product"
                                            >
                                                <Option value="1">Man</Option>
                                                <Option value="2">Man</Option>
                                            </Select>
                                        </Form.Item>

                                        <Form.Item
                                            {...restField}
                                            name={[name, "service_id"]}
                                            fieldKey={[fieldKey, "service_id"]}
                                            rules={[
                                                {
                                                    required: true,
                                                    message:
                                                        "require service",
                                                },
                                            ]}
                                        >
                                            <Select
                                                style={{ width: 200 }}
                                                placeholder="Select Service"
                                            >
                                                <Option value="1">Clean</Option>
                                                <Option value="2">Dry</Option>
                                            </Select>
                                        </Form.Item>

                                        <Form.Item
                                            {...restField}
                                            name={[name, "qty"]}
                                            fieldKey={[fieldKey, "qty"]}
                                            rules={[
                                                {
                                                    required: true,
                                                    message: "Missing qty",
                                                },
                                            ]}
                                        >
                                            <Input placeholder="Qty" />
                                        </Form.Item>
                                        <Form.Item
                                            {...restField}
                                            name={[name, "pcs"]}
                                            fieldKey={[fieldKey, "pcs"]}
                                            rules={[
                                                {
                                                    required: true,
                                                    message: "Missing Pcs",
                                                },
                                            ]}
                                        >
                                            <Input placeholder="Pcs" />
                                        </Form.Item>
                                        <MinusCircleOutlined
                                            onClick={() => remove(name)}
                                        />
                                    </Space>
                                )
                            )}
                            <Form.Item>
                                <Button
                                    type="dashed"
                                    onClick={() => add()}
                                    block
                                    icon={<PlusOutlined />}
                                >
                                    Add More
                                </Button>
                            </Form.Item>
                        </>
                    )}
                </Form.List>
            </Form>
        </Modal>
    );
};

export default FormOrder;
