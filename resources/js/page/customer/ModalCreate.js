import { Modal, Form, Input } from 'antd';

const CollectionCreateForm = ({ visible, onCreate, onCancel }) => {
    const [form] = Form.useForm();    

    form.resetFields();

    return (
      <Modal         
        visible={visible}
        title="Create a new Customer"
        okText="Create"
        cancelText="Cancel"
        onCancel={onCancel}        
        onOk={() => {            
          form
            .validateFields()
            .then((values) => {
              //form.resetFields();
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

  export default CollectionCreateForm;