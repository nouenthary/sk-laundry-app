import React from 'react';
import {Button} from "antd";
import {ShoppingCartOutlined,ShopOutlined, SkinOutlined,CalendarOutlined,SettingOutlined, BarChartOutlined,LoginOutlined} from "@ant-design/icons";
import {Link} from "react-router-dom";
import './App.css';

const Dashboard = () => {

    const logout = () =>{
        localStorage.removeItem('token');
        window.location.reload();
    }

    return (
      <div className="App-header">
          <div className={'wrapper-button'}>

              <div className={'button-item'}>
                  <Link to="/agent">
                  <Button type='primary' block className={'button-menu'}>
                      <ShopOutlined />
                  </Button>
                  <p className={`color-text`}>Agent</p>
                  </Link>
              </div>

              <div className={'button-item'}>
                  <Link to="/customers">
                  <Button type={`danger`} style={{background: 'orange'}} block className={'button-menu'}>
                      <ShoppingCartOutlined />
                  </Button>
                  <p className={`color-text`}>Customer</p>
                  </Link>
              </div>

              <div className={'button-item'}>
                  <Link to="/order">
                      <Button type='primary' block className={'button-menu'}>
                          <SkinOutlined />
                      </Button>
                      <p className={`color-text`}>Order Now</p>
                  </Link>
              </div>

              <div className={'button-item'}>
                  <Link to="/order">
                      <Button type='primary' style={{background: '#f759ab'}} block className={'button-menu'}>
                          <CalendarOutlined />
                      </Button>
                      <p className={`color-text`}>Calendar</p>
                  </Link>
              </div>

              <div className={'button-item'}>
                  <Link to="/report">
                      <Button type='primary' block className={'button-menu'}>
                          <BarChartOutlined />
                      </Button>
                      <p className={`color-text`}>Report</p>
                  </Link>
              </div>

              <div className={'button-item'}>
                  <Link to="/order">
                      <Button type='danger' block className={'button-menu'}>
                          <SettingOutlined/>
                      </Button>
                      <p className={`color-text`}>Setting</p>
                  </Link>
              </div>

              <div className={'button-item'}>
                  <>
                      <Button type='danger' block className={'button-menu'} onClick={logout}>
                          <LoginOutlined/>
                      </Button>
                      <p className={`color-text`}>Logout</p>
                  </>
              </div>


          </div>
      </div>
    );
}

export default Dashboard;