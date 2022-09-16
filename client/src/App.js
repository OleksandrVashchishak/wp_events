import { Routes, Route } from "react-router-dom";
import { GetCalendar, GetList, GetCarsNew, TopBar, Event,Checkout } from './components'
import React from "react";
import './App.scss';

const App = () => {

  return (
    <div className="App container">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
      <TopBar  />

      <Routes>
        <Route path="/home" element={<GetCarsNew  />} />
        <Route path="/calendar" element={<GetCalendar  />} />
        <Route path="/list" element={<GetList  />} />
        <Route path="/event" element={<Event  />} />
        <Route path="/checkout" element={<Checkout  />} />

      </Routes>

    </div>
  );
}

export default App;
