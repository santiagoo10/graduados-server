import React from 'react';
import ReactDOM from 'react-dom';
import { HydraAdmin } from '@api-platform/admin';

//const entrypoint = document.getElementById('api-entrypoint').innerText;

const entrypoint =  process.env.REACT_APP_API_ENTRYPOINT;

ReactDOM.render(
    <HydraAdmin entrypoint={entrypoint}/>,
    document.getElementById('api-platform-admin')
);
