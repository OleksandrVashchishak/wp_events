import * as React from 'react';
import LoginMenu from './LoginMenu';
import NavMenu from './NavMenu';

import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import Container from '@mui/material/Container';

const TopBar = () => {

    return (
        <AppBar position="static">
            <Container maxWidth="xl">
                <Toolbar disableGutters>
                    <NavMenu />
                    <LoginMenu  />
                </Toolbar>
            </Container>
        </AppBar>
    );
}

export default TopBar