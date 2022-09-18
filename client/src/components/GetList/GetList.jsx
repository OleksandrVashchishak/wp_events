import axios from 'axios';
import React from "react";
import DateBar from './DateBar';
import ListItem from './ListItem';
import Pagination from './Pagination';


const GetList = () => {
    const [date, setDate] = React.useState(new Date())
    const [page, setPage] = React.useState(1)
    const [events, setEvents] = React.useState([])
    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        const formatDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`
        console.log(formatDate);
        axios({
            method: 'GET',
            url: apiHost + `/list/${page}/${formatDate}`,
        }).then((result) => {
            setEvents(result.data);
        }).catch(function (err) {
            console.log(err);
        });
        setPage(1)
        console.log(1);

    }, [page, date]);

    return (
        <div className="ax_list">
            <DateBar date={date} setDate={setDate} />

            {events && events.map(event => (
                <ListItem key={event.id} event={event} />
            ))}

            {!events[0] && <h3 className='ax_list-nothing'>Nothing found! Try another date!</h3> }

            <Pagination setPage={setPage} date={date} />
        </div>
    );
}

export default GetList  