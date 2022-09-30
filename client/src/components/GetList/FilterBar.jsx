import React from "react";

const FilterBar = ({ search, setSearh, location, setLocation, getEvents }) => {
    return (
        <div className="ax_filterbar">
            <input type="text" placeholder="Search for events" value={search} onChange={(e) => setSearh(e.target.value)} />
            <input type="text" placeholder="In a location" value={location} onChange={(e) => setLocation(e.target.value)} />
            <button onClick={() => getEvents()} >Find Events</button>
        </div>
    );
}
export default FilterBar