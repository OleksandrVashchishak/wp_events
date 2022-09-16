import React from "react";
import axios from 'axios';

const Event = () => {
    const eventIdQuery = window.location.href.split('=')
    const [eventId, setEventId] = React.useState(eventIdQuery ? eventIdQuery[1] : false);
    const [event, setEvent] = React.useState(eventIdQuery ? eventIdQuery[1] : false);
    const [count, setCount] = React.useState(1);
  
    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        axios({
            method: 'GET',
            url: apiHost + `/single/${eventId}`,
        }).then((result) => {
            setEvent(result.data);
        }).catch(function (err) {
            console.log(err);
        });

    }, []);

    const addToCart = (id) => {
        localStorage.setItem('event_id', id)
        localStorage.setItem('event_count', count)
    }

    const setCountHandler = (count) => {
        if(count <= event.ticket_left) {
            setCount(count)
        }
    }

    return (
        <div className="ax_event">
            <div className="ax_event-top">
                <h3 className="ax_event-title">{event.title}</h3>
                <div className="ax_event-thumb">
                    <img src={event.thumbnail} alt="" className="ax_event-img" />
                </div>
            </div>

            <div className="ax_event-info">
                <div className="ax_event-dates ax_event-info-item">
                    {event.start_date} {event.start_time} - {event.end_date} {event.end_time}
                </div>
                <div className="ax_event-category ax_event-info-item">sport</div>
                <div className="ax_event-location ax_event-info-item">{event.country} - {event.location}</div>
            </div>

            <div className="ax_event-content" dangerouslySetInnerHTML={{ __html: event.content }}></div>

            <div className="ax_event-price">Price: ${event.price}</div>
            <div className="ax-event-tikets">Tickets left: {event.ticket_left}</div>
            <div className="ax-event-buy-wrap">
                <div className="ax-event-count">
                    <span>Ticket count</span>
                    <input type="number" value={count} onChange={(e) => setCountHandler(e.target.value)} />
                </div>
                <button className="ax_event-buy" onClick={() => addToCart(event.id)}>Buy tiket</button>
            </div>

        </div>
    );
}

export default Event