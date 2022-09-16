import React from "react";
import axios from 'axios';

const Checkout = () => {
    const [firstName, setFirstName] = React.useState('fn');
    const [lastName, setLastName] = React.useState('ln');
    const [email, setEmail] = React.useState('em@user.com');
    const [event, setEvent] = React.useState({});
    const [eventId, setEventId] = React.useState(localStorage.getItem('event_id'));
    const [count, setCount] = React.useState(localStorage.getItem('event_count'));

    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json';
        axios({
            method: 'POST',
            url: apiHost + `/ax/v1/checkout`,
            params: {
                event_id: eventId,
                count: count,
            }
        }).then((response) => {
            setEvent(response.data)
        }).catch(function (err) {
            console.log(err);
        });

    }, []);

    const paymentHandler = () => {
        const apiHost = 'http://cars/wp-json';
        axios({
            method: 'POST',
            url: apiHost + `/ax/v1/send_invoice`,
            params: {
                first_name: firstName,
                last_name: lastName,
                email: email,
                tickets_count: count,
                total: count * event.price,
                event_id: eventId,
            }
        }).then((response) => {
            console.log(response.data);
        }).catch(function (err) {
            console.log(err);
        });
    }


    return (
        <div className="ax_checkout">
            <h3 className="ax_checkout-title">Registration Checkout</h3>
            <div className="ax_checkout-details">
                <div className="ax_checkout-row">
                    <div className="ax_checkout-cell ax_checkout-cell-40">Name</div>
                    <div className="ax_checkout-cell ax_checkout-cell-20">Qty</div>
                    <div className="ax_checkout-cell ax_checkout-cell-20">Price</div>
                    <div className="ax_checkout-cell ax_checkout-cell-20">Total</div>
                </div>
                <div className="ax_checkout-row">
                    <div className="ax_checkout-cell ax_checkout-cell-40">{event.title}</div>
                    <div className="ax_checkout-cell ax_checkout-cell-20">{count}</div>
                    <div className="ax_checkout-cell ax_checkout-cell-20">${event.price}</div>
                    <div className="ax_checkout-cell ax_checkout-cell-20">${count * event.price}</div>
                </div>
            </div>

            <div className="ax_checkout-info">
                <h3>Customer info</h3>
                <label>
                    First Name
                    <input type="text" value={firstName} onChange={(e) => setFirstName(e.target.value)} />
                </label>
                <label>
                    Last Name
                    <input type="text" value={lastName} onChange={(e) => setLastName(e.target.value)} />
                </label>
                <label>
                    Email Address
                    <input type="text" value={email} onChange={(e) => setEmail(e.target.value)} />
                </label>

            </div>

            <div className="ax_checkout-pay">
                <button onClick={() => paymentHandler()}>Pay</button>
            </div>
        </div>
    );
}

export default Checkout