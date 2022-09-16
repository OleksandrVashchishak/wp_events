import * as React from 'react';
import { Link } from "react-router-dom";

import Box from '@mui/material/Box';
import Button from '@mui/material/Button';

const LoginMenu = () => {
    return (
        <Box sx={{ display: { xs: 'none', md: 'flex' }, mr: 1 }}>
            <Button sx={{ my: 2, color: 'white' }} >
                <Link to="/checkout">Checkout</Link>
            </Button>
        </Box>
    );
}

export default LoginMenu