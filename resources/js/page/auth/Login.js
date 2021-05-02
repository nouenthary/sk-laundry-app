import React, {useState} from 'react';
import {Form, Input, Button, Card,message} from 'antd';
import './Login.css';
import PropTypes from 'prop-types';
import {authLogin} from '../../utils/config';

const layout = {
    labelCol: {
        span: 24,
    },
    wrapperCol: {
        span: 24,
    },
};

const Login = ({setToken })=> {

    const [loading, setLoading] = useState(false);

    const onFinish = (values) => { 
        setLoading(true);
        return authLogin(values).then(res=>{
            console.log(res.data.token);
            if(res == null){
                message.error('login error ...');
                setLoading(false);
            }
            else if(res.status !== null && res.status === 200){
                setToken(res.data.token);
                setLoading(false);
                window.location.reload();
            }
       });
    };

    const onFinishFailed = (errorInfo) => {
        console.log('Failed:', errorInfo);
        setLoading(false);
    };

    return(
        <div className={`card-login`}>
            <Card style={{width: '400px'}}>

                <div style={{textAlign: 'center'}}>
                    <img src='logo192.png' style={{height: '60px'}} alt={`me`}/>
                    <h1>Admin Portal</h1>
                </div>

        <Form
            {...layout}
            name="basic"
            initialValues={{
                remember: true,
            }}
            onFinish={onFinish}
            onFinishFailed={onFinishFailed}
        >
            <Form.Item
                name="username"
                rules={[
                    {
                        required: true,
                        message: 'Please input your username!',
                    },
                ]}
            >
                <Input placeholder={`Username`}/>
            </Form.Item>

            <Form.Item
                name="password"
                rules={[
                    {
                        required: true,
                        message: 'Please input your password!',
                    },
                ]}
            >
                <Input.Password placeholder={`Password`}/>
            </Form.Item>


            <Form.Item >
                <Button block type="primary" loading={loading} htmlType="submit">
                    Login
                </Button>
            </Form.Item>
        </Form>
            </Card>
        </div>
    );
}

Login.propTypes = {
    setToken: PropTypes.func.isRequired
};

export default Login;