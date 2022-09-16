import axios from 'axios';
import React from "react";
import ListItem from './ListItem';
import Pagination from './Pagination';


const GetList = () => {
    const [page, setPage] = React.useState(1)
    const [events, setEvents] = React.useState([])
    console.log(page);
    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        axios({
            method: 'GET',
            url: apiHost + `/list/${page}`,
        }).then((result) => {
            setEvents(result.data);
        }).catch(function (err) {
            console.log(err);
        });

    }, [page]);

    return (
        <div className="ax_list">
            {events && events.map(event => (
                <ListItem key={event.id} event={event} />
            ))}


            <Pagination setPage={setPage} />
        </div>
    );
} 

export default GetList  