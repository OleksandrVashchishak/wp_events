import React from "react";
import { useNavigate } from 'react-router-dom';

const ListItem = ({ event }) => {
    const navigate = useNavigate();
    const handleClickEvent = (id) => {
        navigate(`/event?id=${id}`);
    }

    return (
        <div className="ax_list-item">
            <div className="ax_list-info">
                <p className="ax_list-dates">
                    {event.start_date} @ {event.start_time} - {event.end_date} @ {event.end_time}
                </p>
                <h3 className="ax_list-title">{event.title}</h3>
                <span className="ax_list-location">Location: {event.country} - {event.location}</span>
                {event.cats && <span className="ax_list-category">
                    Category:
                    {event.cats.map(cat => (
                        cat.name
                    ))}
                </span>}
                <div className="ax_list-content" dangerouslySetInnerHTML={{ __html: event.content }} ></div>
                <span className="ax_list-price">Price: ${event.price}</span>
                <button onClick={() => handleClickEvent(event.id)} >See more</button>
                {event.pdf_link && <a className="ax_list-pdf" href={event.pdf_link} target='_blank'> See event in PDF</a>}

            </div>
            <div className="ax_list-img-wrap">
                {event.thumbnail && <img src={event.thumbnail} alt="image" className="ax_list-img" />}
            </div>
        </div>
    );
}

export default ListItem