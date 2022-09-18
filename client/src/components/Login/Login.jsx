import axios from 'axios';
import React from "react";
import { userLogin as userLoginHelper } from './userLogin.js'

import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';

const Login = ({ setIsLogin }) => {
    const [login, setLogin] = React.useState('');
    const [password, setPassword] = React.useState('');

    const userLogin = () => {
        userLoginHelper(axios, login, password, setIsLogin, false)
    }

    return (
        <div className="login-wrapper">
            <h3>Login</h3>
            <div>
                <TextField value={login} onChange={(e) => setLogin(e.target.value)} label="User" variant="standard" />
                <br />
                <TextField value={password} onChange={(e) => setPassword(e.target.value)} label="Password" type="password" variant="standard" />
                <br />
                <br />
                <Button onClick={() => userLogin()} variant="outlined">Login</Button>
            </div>
        </div>
    );
}

export default Login