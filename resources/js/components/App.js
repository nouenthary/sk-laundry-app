import React from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import {Button} from 'antd';
import {
    BrowserRouter, Route , Switch
} from 'react-router-dom';
import Login from '../page/auth/Login';
import Home from '../page/Home';
import useToken from '../utils/useToken';
import Dashboard from './Dashboard';
import Customer from '../page/customer/Customer';
import Service from '../page/service';
import Order from '../page/order/Order';

function App() {
    const {setToken, token} = useToken();    

    if(!token){
        return <Login setToken={setToken}/>
    }

    return (
        <BrowserRouter>
            <Switch>
                <Route exact path="/" component={Dashboard}/> 
                <Route exact path="/customers" component={Customer}/> 
                <Route exact path="/services" component={Service}/> 
                <Route exact path="/orders" component={Order}/> 
            </Switch>           
        </BrowserRouter>        
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
