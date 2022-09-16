import axios from 'axios';
import React from "react";


const Pagination = ({setPage}) => {
    const [count, setCount] = React.useState([])
    const [active, setActive] = React.useState(1)

    React.useEffect(() => {
        const apiHost = 'http://cars/wp-json/ax/v1';
        axios({
            method: 'GET',
            url: apiHost + '/list_pagination/1',
        }).then((result) => {
            setCount(result.data);
        }).catch(function (err) {
            console.log(err);
        });

    }, []);

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