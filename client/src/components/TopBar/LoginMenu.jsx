import * as React from 'react';
import { Link } from "react-router-dom";

import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import IconButton from '@mui/material/IconButton';
import Avatar from '@mui/material/Avatar';

const LoginMenu = ({ isLogin, setIsLogin }) => {
    const logout = () => {
        localStorage.removeItem("token");
        localStorage.removeItem("email");
        setIsLogin(false)
    }
    return (
        <Box sx={{ display: { xs: 'none', md: 'flex' }, mr: 1 }}>
            {isLogin && <>
                <Button sx={{ my: 2, color: 'white' }} >
                    <Link to="/checkout">Checkout</Link>
                </Button>

                <IconButton sx={{ p: 0 }}>
                    <Link to="/account">
                        <Avatar alt="Remy Sharp" src="/static/images/avatar/2.jpg" />
                    </Link>
                </IconButton>

                <Button onClick={() => logout()} sx={{ my: 2, color: 'white' }} >
                    Logout
                </Button>  </>}

            {!isLogin && <>
                <Button sx={{ my: 2, color: 'white' }} >
                    <Link to="/login">Login</Link>
                </Button>
                <Button sx={{ my: 2, color: 'white' }} >
                    <Link to="/registration">Registration</Link>
                </Button>
            </>}
        </Box>
    );
}

export default LoginMenu