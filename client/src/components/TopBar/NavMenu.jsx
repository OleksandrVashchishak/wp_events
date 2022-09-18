import * as React from 'react';
import { Link } from "react-router-dom";

import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import AdbIcon from '@mui/icons-material/Adb';

const NavMenu = () => {
    return (
        <>
            <AdbIcon sx={{ display: { xs: 'none', md: 'flex' }, mr: 1 }} />
            <Box sx={{ flexGrow: 1, display: { xs: 'none', md: 'flex' } }}>
                <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                    <Link to="/">List</Link>
                </Button>

                <Button sx={{ my: 2, color: 'white', display: 'block' }}  >
                    <Link to="/calendar">Calendar</Link>
                </Button>
            </Box>
        </>
    );
}

export default NavMenu