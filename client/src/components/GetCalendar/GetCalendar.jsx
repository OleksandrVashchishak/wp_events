import axios from 'axios';
import React from "react";
import { useNavigate } from 'react-router-dom';
import { Calendar, momentLocalizer } from 'react-big-calendar'
import moment from 'moment'
import "react-big-calendar/lib/css/react-big-calendar.css";
const localizer = momentLocalizer(moment)

const GetCalendar = () => {
    const [events, setEvents] = React.useState([])
    const navigate = useNavigate();
    const handleClickEvent = (event) => {
        navigate(`/event?id=${event.id}`);
    }

    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        axios({
            method: 'GET',
            url: apiHost + '/calendar/1',
        }).then((result) => {
            setEvents(result.data);
        }).catch(function (err) {
            console.log(err);
        });

    }, []);


    return (
        <div className="App">
            <Calendar
                localizer={localizer}
                events={events}
                startAccessor="start"
                endAccessor="end"
                style={{ height: 900 }}
                onSelectEvent={(e) => handleClickEvent(e)}
            />

        </div>
    );
}

export default GetCalendar