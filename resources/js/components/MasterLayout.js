import { Layout, Menu } from "antd";
import { TableOutlined } from "@ant-design/icons";
import { Link } from "react-router-dom";

const { Header, Content } = Layout;

const MasterLayout = (props) => {
    const { children } = props;
    return (
        <Layout>
            <Header style={{ position: "fixed", zIndex: 1, width: "100%" }}>
                <div className="logo" />
                <Menu
                    theme="dark"
                    mode="horizontal"
                    defaultSelectedKeys={["2"]}
                >
                    <Menu.Item key="4">
                        <Link to={`/`}>
                            <TableOutlined />
                        </Link>
                    </Menu.Item>

                    <Menu.Item key="customers">
                        <Link to={`/customers`}>List Customer</Link>
                    </Menu.Item>

                    <Menu.Item key="service">
                        <Link to={`/services`}>Service</Link>
                    </Menu.Item>

                    <Menu.Item key="order">
                        <Link to={`/orders`}>Order</Link>                    
                    </Menu.Item>
                    <Menu.Item key="3">List Order</Menu.Item>

                    <Menu.Item key="logout" style={{ float: "right" }}>
                        Username :{" "}
                    </Menu.Item>
                </Menu>
            </Header>
            <Content className="site-layout" style={{ marginTop: 64 }}>
                <div
                    className="site-layout-background"
                    style={{ padding: "10px 0", height: "100vh" }}
                >
                    {children}
                </div>
            </Content>
        </Layout>
    );
};

export default MasterLayout;
