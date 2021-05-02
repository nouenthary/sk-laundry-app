import { message , Table, Button, Space, Modal} from 'antd';
import React,{useState, useEffect} from 'react';
import MasterLayout from "../../components/MasterLayout";
import axios from '../../utils/config';
import {ReloadOutlined, PlusOutlined, EditOutlined, DeleteOutlined, ExclamationCircleOutlined} from '@ant-design/icons';
import ModalCreateService from './ModalCreateService';
import moment from 'moment';
import ModalUpdateService from './ModalUpdateService';

const Service = () => {

    const [state, setState] = useState({
        data: [],
        loading: false,
        visible: false,
        formEdit : false,
        service_type: [],
        value : {}
    });

    const [service,setService] = useState([]);

    useEffect(() => {
        getService();                       
    },[]);


    const getService = () => {
        setState({...state, loading : true});        
        axios.get('/services',{}).then(res => {            
            setState({...state, data : res.data.data, loading: false});    
        }).catch(error => {
            message.error(error);
        });    
        
        // get service type
        axios.get('/service-type',{}).then(res=>{           
            setService(res.data);
        }).catch(error=> {
            console.log(error);
        });
    }

    const columns = [
        {
            title: 'Service',
            dataIndex: 'service_name',
            key: 'service_name',
            render: text => <a>{text}</a>,
        },
        {
            title: 'Price (KHR)',
            dataIndex: 'price',
            key: 'price'            
        },
        {
            title: 'Discount (%)',
            dataIndex: 'discount',
            key: 'discount'            
        },
        {
            title: 'Start Date',
            dataIndex: 'start_date',
            key: 'start_date'            
        },
        {
            title: 'End Date',
            dataIndex: 'end_date',
            key: 'end_date'            
        },
        {
            title: 'Unit',
            dataIndex: 'unit',
            key: 'unit'            
        },               
        {
            title: 'Unit Type',
            dataIndex: 'unit_type',
            key: 'unit_type'            
        }, 
        {
            title: 'Type',
            dataIndex: 'type',
            key: 'type'            
        }, 
        // {
        //     title: 'Auditor',
        //     dataIndex: 'user_id',
        //     key: 'user_id'            
        // },  
        {
            title: 'Action',
            key: 'action',
            render: (text, record) => (
              <Space size="middle">              
                <Button size={`small`} icon={<EditOutlined />} onClick={() => setState({...state,formEdit: true, value: record})}/>              
                <Button  size={`small`} type={`danger`} icon={<DeleteOutlined />} onClick={() => confirm(record.id)}/>
              </Space>
            ),
          },     
    ];

    const convertDate = (date) => {
        return moment(date).format('YYYY-MM-DD');        
    }

    const onCreate = (values) => {
        let start_date = '';
        let end_date = '';

        if(values.start_date != null){
            start_date = convertDate(start_date._d);
        }     
        
        if(values.end_date != null){
            end_date = convertDate(end_date._d);
        } 
        
        axios.post('/services',{...values}).then(res=>{
            if(res.data.error){
                message.error(res.data.error);
                return;
            }

            setState({...state, visible: false});            
        }).catch(error=> {
            message.error(error);
        });
    }

    const confirm = (id) =>{
        Modal.confirm({
            title: 'Confirm',
            icon: <ExclamationCircleOutlined />,
            content: 'Are you sure remove ?',
            okText: 'Delete',
            cancelText: 'Cancel',
            onOk: () => {         
              axios.delete('/services/' +id).then(response=>{            
                message.success(response.data.message);
                getService();    
              }).catch(error=> {
                message.error(error);
              });
            }
          });
    }

    const onUpdate = (values) => {       

        axios.put('/services/'+ values.id ,{...values}).then(response=>{       
            
            if(response.data.error){
                message.success(response.data.error);
            }

            message.success(response.data.message);

            setState({...state, formEdit: false});
                
          }).catch(error=> {
            message.error(error);
          });         
    }


    const onSelectChange = (selectedRowKeys) => {
        console.log('selectedRowKeys changed: ', selectedRowKeys);        
      };

      const rowSelection = {
        onChange: onSelectChange,
      };
      

    return (
        <MasterLayout>

         <Button onClick={() => {
          setState({...state, visible: true});
          }}>
            <PlusOutlined /> New
          </Button> 

          <Button onClick={getService}>
           <ReloadOutlined /> Relaod
          </Button> 

          <div style={{paddingTop: 5}}/>

            <Table 
            loading={state.loading}
            dataSource={state.data} 
            columns={columns}
            size={`small`}
            pagination={{size: 'middle', pageSize: 20}}
            rowSelection={rowSelection}
            rowKey={`id`}
            bordered
            /> 

            <ModalCreateService
                 visible={state.visible}
                 onCreate={onCreate}              
                 onCancel={() => {
                   setState({...state, visible:false});
                 }}
                 serviceType={service}
            />


            <ModalUpdateService
                 visible={state.formEdit}
                 onCreate={onUpdate}              
                 onCancel={() => {
                   setState({...state, formEdit:false});
                 }}
                 serviceType={service}
                 value={state.value}   
            />     

        </MasterLayout>
    );
}

export default Service;