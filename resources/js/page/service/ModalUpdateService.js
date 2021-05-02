import { Modal, Select, DatePicker , Row, Col , InputNumber, Input, Form} from 'antd';


const { Option } = Select;

const ModalUpdateService = ({ visible, onCreate, onCancel , serviceType, value}) => {
    const [form] = Form.useForm();    
   
    const service = serviceType; 

    const data = {
        ...value, start_date: '', end_date: ''
    };
    //console.log(data);
       
    if(data){
        form.setFieldsValue({...data});
    }


    const handleChange = (event) => {
        const value = event.target.value.replace(/\+|-/gi, "");

        if (value.length) {
            const number = parseInt(value);
            //setNum(number);
        }
    };

    return (
      <Modal         
        visible={visible}
        title="Update Service"
        okText="Create"
        cancelText="Cancel"
        onCancel={onCancel}        
        onOk={() => {                
          form
            .validateFields()
            .then((values) => {              
              onCreate(values);
            })
            .catch((info) => {
              console.log('Validate Failed:', info);
            });
        }}
        width={600}
      >        
        <>
       
        <Form                  
          layout="vertical"          
          name="form_in_modal_update"
          form={form}               
        >     
             <Form.Item
                    name="id"
                    rules={[
                    {
                        required: true,
                    },
                    ]}
                    style={{display : 'none'}}
                >
                    <Input />         
                </Form.Item>

                     
           <Row  gutter={24}> 
           
                <Col span={12}>              
                <Form.Item
                    name="service_name"
                    label="Service"
                    rules={[
                    {
                        required: true,
                        message: 'Please input the name !',
                    },
                    ]}
                >
                    <Select                        
                        style={{ width: '100%' }}
                        placeholder="Select service"
                        optionFilterProp="children"                            
                    >
                       {service != null && service.map(item => (
                         <Option key={item}>{item}</Option>
                        ))}          
                    </Select>  
                </Form.Item>                
                </Col>  

                <Col span={12}>
                    <Form.Item
                        name="price"
                        label="Price"
                        rules={[
                        {
                            required: true,
                            message: 'Please input the Price!'                                                                                                                               
                        },
                        ]}
                    >
                        <InputNumber autoFocus={true} style={{width: '100%'}} />
                    </Form.Item> 
                </Col> 


                <Col span={12}>
                <Form.Item
                        name="discount"
                        label="Discount"
                        rules={[
                        {
                            required: true,
                            message: 'Please input the discount between 0 to 100 !',                                                                                
                        },
                        ]}
                    >
                        <InputNumber autoFocus={true} style={{width: '100%'}} />
                    </Form.Item>    
                </Col>

                <Col span={12}>
                    <Form.Item
                        name="start_date"
                        label="Start Date"           
                    >
                        <DatePicker style={{ width: '100%' }} disabled />
                    </Form.Item>
                </Col>

                <Col span={12}>
                    <Form.Item
                        name="end_date"
                        label="End Date"           
                    >
                        <DatePicker  style={{ width: '100%' }} disabled />
                    </Form.Item>
                </Col>

                <Col span={12}>
                <Form.Item
                    name="unit_type"
                    label="Unit Type"
                    rules={[
                    {
                        required: true,
                        message: 'Please input the unit Type !',
                    },
                    ]}
                >
                    <Select                
                        style={{ width: '100%' }}
                        placeholder="Select unit type"
                        optionFilterProp="children"                            
                    >
                        <Option value="Kgs">Kgs</Option>                
                        <Option value="Pcs">Pcs</Option>                
                    </Select>  
                </Form.Item>
                </Col>

                <Col span={12}>
                <Form.Item
                    name="unit"
                    label="Unit"
                    rules={[
                    {
                        required: true,
                        message: 'Please input the unit !',                                                
                    },
                    ]}
                >
                   <InputNumber autoFocus={true} style={{width: '100%'}} />
                </Form.Item>
                </Col>

                <Col span={12}>
                <Form.Item
                    name="type"
                    label="Type"
                    rules={[
                    {
                        required: true,
                        message: 'Please input the Type !',
                    },
                    ]}
                >
                    <Select                        
                        style={{ width: '100%' }}
                        placeholder="Select type"
                        optionFilterProp="children"                            
                    >
                        <Option value="Customer">Customer</Option>                
                        <Option value="Agent">Agent</Option>                
                        <Option value="Contact">Contact</Option>                
                        <Option value="Online">Online</Option>                
                    </Select>  
                </Form.Item>
                </Col>
            </Row>                                                                                             
        </Form>
        </>              
      </Modal>
    );
  };


  export default ModalUpdateService;