import React from "react";
import axios from 'axios';

const OrderItem = ({ order, setRender }) => {
    const canRefund = order.refund == 'none' ? true : false

    const hundleRefund = (id) => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        axios({
            method: 'GET',
            url: apiHost + `/refund/${id}`,
        }).then((result) => {
            console.log(result.data);
            setRender(Math.random())
        }).catch(function (err) {
            console.log(err);
        });
    }
    return (
        <div className="ax_order-row">
            <span className="ax_order-cell ax_order-cell-10">{order.id}</span>
            <span className="ax_order-cell ax_order-cell-25">{order.title}</span>
            <span className="ax_order-cell ax_order-cell-25">{order.status}</span>
            <span className="ax_order-cell ax_order-cell-10">{order.tickets_count}</span>
            <span className="ax_order-cell ax_order-cell-10">${order.total}</span>
            <span className="ax_order-cell ax_order-cell-20">
                {canRefund && <button onClick={() => hundleRefund(order.id)}>Refund</button>}
                {!canRefund && order.refund}
            </span>
        </div>
    );
}

export default OrderItem