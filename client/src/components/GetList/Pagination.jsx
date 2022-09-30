import axios from 'axios';
import React from "react";


const Pagination = ({ setPage, date, search, location, events }) => {
    const [count, setCount] = React.useState([])
    const [active, setActive] = React.useState(1)

    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        const formatDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`
        const _search = search.length > 2 ? search : 0
        const _location = location.length > 2 ? location : 0
        axios({
            method: 'GET',
            url: apiHost + '/list_pagination/' + `${formatDate}/${_search}/${_location}`,
        }).then((result) => {
            setCount(result.data);
        }).catch(function (err) {
            console.log(err);
        });
    }, [date, events]);

    const handlePagination = (page) => {
        setActive(page)
        setPage(page)
    }

    return (
        <div className="ax_list-pagination">
            {count && count.map(page => (
                <button onClick={() => handlePagination(page)} key={page} className={active == page ? 'active' : ''} >
                    {page}
                </button>
            ))}
        </div>
    );
}

export default Pagination