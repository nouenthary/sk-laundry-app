import { Layout, Menu } from 'antd';
import {TableOutlined} from '@ant-design/icons';

const { Header, Content, Footer } = Layout;

const MasterLayout = (props) => {
    const {children}  = props;
    return (      
            <Layout>
                <Header style={{ position: 'fixed', zIndex: 1, width: '100%' }}>
                <div className="logo" />
                <Menu theme="dark" mode="horizontal" defaultSelectedKeys={['2']}>
                    <Menu.Item key="4"><TableOutlined /></Menu.Item>
                    <Menu.Item key="1">List Customer</Menu.Item>
                    <Menu.Item key="2">Order</Menu.Item>
                    <Menu.Item key="3">List Order</Menu.Item>
                </Menu>
                </Header>
                <Content className="site-layout" style={{ marginTop: 64 }}>                
                <div className="site-layout-background" style={{ padding: '10px 0', height: '100vh' }}>
                {children}
                </div>
                </Content>
            </Layout>        
    );
}

export default MasterLayout;