import react, {useEffect, useState} from 'react';
import { Button } from "antd";
import MasterLayout from "../../components/MasterLayout";
import {ShoppingCartOutlined} from '@ant-design/icons';
import FormOrder from "./FormOrder";
import axios from '../../utils/config';

// {
//     "category_id": "1",
//     "product_id": "1",
//     "service_id": "1",
//     "qty": "10",
//     "weight": "10",
//     "customer_id": "5"            
// },

const Order = () => {

    const [state, setState]= useState({
        data: [],
        visible: false,
        laoding: false,
        customers: [],
        categories: [],
        products: [],
        services: []
    });

    useEffect(() => {
        getCustomerWithPhone();

        getCategory();

        getProducts();

        getServices();
    },[]);

    const getCustomerWithPhone = () => {
        axios.get('/customer-with-phone',{}).then(res=> {            
            setState({...state, customers: res.data});    
        }).catch(err=> {
            console.log(err);
        });
    }

    const getCategory = ()=> {
        axios.get('/category-name',{}).then(res=> {                     
            setState({...state, categories: res.data});    
        }).catch(err=> {
            console.log(err);
        });
    }

    const getProducts = ()=> {
        axios.get('/products-name',{}).then(res=> {                     
            setState({...state, products: res.data});    
        }).catch(err=> {
            console.log(err);
        });
    }

    const getServices = ()=> {
        axios.get('/services-name',{}).then(res=> {                     
            setState({...state, services: res.data});    
        }).catch(err=> {
            console.log(err);
        });
    }


    const onCreate = (values) => {
        console.log(values);
    };

    return (
        <MasterLayout>
            <Button 
                 onClick={() => {
                    setState({ ...state, visible: true });
                }}
            >
                <ShoppingCartOutlined /> Order
            </Button>

            <FormOrder
                 visible={state.visible}
                 onCreate={onCreate}
                 onCancel={() => {
                     setState({ ...state, visible: false });
                 }}
                 customers={state.customers}
                 categories={state.categories}
                 products={state.products}
                 services={state.services}
            />
        </MasterLayout>
    );
};

export default Order;
