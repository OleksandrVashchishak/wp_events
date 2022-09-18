import axios from 'axios';
import React from "react";
import { userLogin } from './userLogin.js'

import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';

const Registration = ({ setIsLogin }) => {
    const [login, setLogin] = React.useState('');
    const [email, setEmail] = React.useState('');
    const [password, setPassword] = React.useState('');

    const userRegistration = () => {
        var apiHost = 'http://cars/wp-json';
        axios({
            method: 'POST',
            url: apiHost + `/wm/v1/register_user`,
            params: {
                username: login,
                email: email,
                password: password
            }
        }).then((response) => {
            console.log(response.data);
            if (response.data) {
                userLogin(axios, login, password, setIsLogin, true)
            }
        }).catch(function (err) {
            console.log(err);
        });
    }

    return (
        <div className="login-wrapper">
            <h3>Registarion</h3>
            <div>
                <TextField value={login} onChange={(e) => setLogin(e.target.value)} label="User" variant="standard" />
                <br />
                <TextField value={email} onChange={(e) => setEmail(e.target.value)} label="Email" variant="standard" />
                <br />
                <TextField value={password} onChange={(e) => setPassword(e.target.value)} label="Password" type="password" variant="standard" />
                <br />
                <br />
                <Button onClick={() => userRegistration()} variant="outlined">Registration</Button>
            </div>

        </div>
    );
}

export default Registration