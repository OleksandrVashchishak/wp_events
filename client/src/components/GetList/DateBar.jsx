import React from "react";

const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
];

const DateBar = ({ date, setDate }) => {
    const handlerDate = (action) => {
        if (action === 'plus') {
            setDate(new Date(date.setDate(date.getDate() + 1)))
        }
        if (action === 'minus') {
            setDate(new Date(date.setDate(date.getDate() - 1)))
        }
    }

    return (
        <div className="ax_datebar">
            <button onClick={() => handlerDate('minus')}>-</button>
            <button onClick={() => handlerDate('plus')}>+</button>
            <h3 className="ax_datebar-title">{months[date.getMonth()]} {date.getDate()}</h3>
        </div>
    );
}

export default DateBar