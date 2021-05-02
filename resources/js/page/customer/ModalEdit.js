import { Modal, Form, Input } from 'antd';

const ModalEdit = ({ visible, onCreate, onCancel , value}) => {
    const [form] = Form.useForm();        

    if(value){      
        form.setFieldsValue({...value});
    }    
    
    return (
      <Modal         
        visible={visible}
        title="Edit Customer"
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
      >
        <Form
          form={form}
          layout="vertical"
          name="form_in_modal"
          initialValues={{
            modifier: 'public',
          }}
        >
          <Form.Item
              style={{display: 'none'}}                
              name="id"                      
              rules={[
                {
                  required: true                        
                },
              ]}
            >
            <Input />
          </Form.Item>

          <Form.Item
            name="name"
            label="Name"
            rules={[
              {
                required: true,
                message: 'Please input the name !',
              },
            ]}
          >
            <Input />
          </Form.Item>

          <Form.Item
            name="phone"
            label="Phone"
            rules={[
              {
                required: true,
                message: 'Please input the Phone!',
              },
            ]}
          >
            <Input />
          </Form.Item>

          <Form.Item name="address" label="Address">
            <Input type="textarea" />
          </Form.Item>
         
        </Form>
      </Modal>
    );
  };

  export default ModalEdit;