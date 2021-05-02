import { Modal, Form, Select, DatePicker , Row, Col , InputNumber} from 'antd';

const { Option } = Select;

const ModalCreateService = ({ visible, onCreate, onCancel , serviceType}) => {
    const [form] = Form.useForm();    
   
    form.resetFields();

    const service = serviceType; 

    return (
      <Modal         
        visible={visible}
        title="Update Service"
        okText="Update"
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
        <Form
          form={form}
          layout="vertical"
          name="form_in_modal_create"         
        >

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
                            message: 'Please input the Price!', 
                            type: 'number',
                            min: 1,
                            max: 1000000,                         
                        },
                        ]}
                    >
                        <InputNumber style={{width: '100%'}} />
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
                            type: 'number',
                            min: 0,
                            max: 100,                            
                        },
                        ]}
                    >
                        <InputNumber style={{width: '100%'}} />
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
                        type: 'number',
                        min: 1,
                        max: 100,
                    },
                    ]}
                >
                   <InputNumber style={{width: '100%'}} />
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
      </Modal>
    );
  };

  export default ModalCreateService;