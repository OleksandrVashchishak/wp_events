import { Routes, Route } from "react-router-dom";
import { GetCalendar, GetList, GetCarsNew, TopBar, Event, Checkout, Thanks, Login, Registration, Account } from './components'
import React from "react";
import './App.scss';

const App = () => {
  const [isLogin, setIsLogin] = React.useState(false);

  React.useEffect(() => {
    localStorage.getItem("token") && setIsLogin(true)
  }, [isLogin]);
  return (
    <div className="App container">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
      <TopBar isLogin={isLogin} setIsLogin={setIsLogin} />

      <Routes>
        <Route path="/" element={<GetList />} />
        <Route path="/calendar" element={<GetCalendar />} />
        <Route path="/event" element={<Event isLogin={isLogin} />} />
      
      </Routes>

      {isLogin && <Routes>
        <Route path="/checkout" element={<Checkout />} />
        <Route path="/thanks" element={<Thanks />} />
        <Route path="/account" element={<Account />} />
      </Routes>}

      {!isLogin && <Routes>
        <Route path="login" element={<Login setIsLogin={setIsLogin} />} />
        <Route path="registration" element={<Registration setIsLogin={setIsLogin} />} />
      </Routes>}
     

    </div>
  );
}

export default App;
