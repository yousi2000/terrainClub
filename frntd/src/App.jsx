import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import './App.css';
import Login from './pages/Login';
import Logout from './pages/Logout';
import Notfound from './pages/Notfound';
import Home from './pages/Home';
import Register from './pages/Register';


function App() {
    return (
      <BrowserRouter>
        <Routes>
          <Route>
          {/* <Route path="/" element={<Layout />}> */}
          
            {/* <Route index element={<Home />} /> */}
            <Route path="/" element={<Home />} />
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register/>} />
            <Route path="/logout" element={<Logout />} />
            <Route path="/*" element={<Notfound />} />
          </Route>
        </Routes>
      </BrowserRouter>
    );
  }
export default App;
