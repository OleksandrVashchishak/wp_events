import axios from 'axios';
import React from "react";
import DateBar from './DateBar';
import FilterBar from './FilterBar';
import ListItem from './ListItem';
import Pagination from './Pagination';


const GetList = () => {
    const [search, setSearh] = React.useState('')
    const [location, setLocation] = React.useState('')
    const [date, setDate] = React.useState(new Date())
    const [page, setPage] = React.useState(1)
    const [events, setEvents] = React.useState([])
    React.useEffect(() => {
        getEvents()
    }, [page, date]);

    const getEvents = () => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        const formatDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`
        const _search = search.length > 2 ? search : 0
        const _location = location.length > 2 ? location : 0
        axios({
            method: 'GET',
            url: apiHost + `/list/${page}/${formatDate}/${_search}/${_location}`,
        }).then((result) => {
            setEvents(result.data);
        }).catch(function (err) {
            console.log(err);
        });
        setPage(1)
    }

    return (
        <div className="ax_list">
            <FilterBar search={search} setSearh={setSearh} location={location} setLocation={setLocation} getEvents={getEvents} />
            <DateBar date={date} setDate={setDate} />

            {events && events.map(event => (
                <ListItem key={event.id} event={event} />
            ))}

            {!events[0] && <h3 className='ax_list-nothing'>Nothing found! Try another date!</h3>}
            <Pagination setPage={setPage} date={date} search={search} location={location} events={events}/>
        </div>
    );
}

export default GetList  