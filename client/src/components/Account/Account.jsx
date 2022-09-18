import React from "react";
import axios from 'axios';
import OrderItem from './OrderItem';

const Checkout = () => {
    const [render, setRender] = React.useState(1)
    const [orders, setOrders] = React.useState([])
    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        const user_id = localStorage.getItem("user_id")
        axios({
            method: 'GET',
            url: apiHost + `/user_orders/${user_id}`,
        }).then((result) => {
            setOrders(result.data);
        }).catch(function (err) {
            console.log(err);
        });
    }, [render]);

    return (
        <div className="ax_account">
           <h3>Orders table</h3>
            <div className="ax_account-orders">
                <div className="ax_order-row">
                    <span className="ax_order-cell ax_order-cell-10">ID</span>
                    <span className="ax_order-cell ax_order-cell-25">Title</span>
                    <span className="ax_order-cell ax_order-cell-25">Status</span>
                    <span className="ax_order-cell ax_order-cell-10">Count</span>
                    <span className="ax_order-cell ax_order-cell-10">Total</span>
                    <span className="ax_order-cell ax_order-cell-20">Refund</span>
                </div>
                {orders && orders.map(order => (
                    <OrderItem key={order.id} order={order} setRender={setRender} />
                ))}
            </div>
        </div>
    );
}

export default Checkout