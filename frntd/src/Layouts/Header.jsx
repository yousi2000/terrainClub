import React from 'react';
import { Nav } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

export default function Header() {
  return (
  <>
  <nav className="navbar navbar-dark bg-dark container-fluid">
       
       <span className="p-2 navbar-brand">Terrain</span>
   
   

    
       <Nav className='nav_bar_wrapper'>
         {
           localStorage.getItem('user-info')?
           <>
            <Nav.Item>
            <Link to="/" className='nav-link'>Home</Link>
           </Nav.Item>
             <Nav.Item>
               <Link to="/logout" className='nav-link'>Logout</Link>
                  
           </Nav.Item>
           </>
           :
           <>
             <Nav.Item>
             <Link to="/register" className='nav-link'>S'inscrire</Link>
             </Nav.Item>
             <Nav.Item>
             <Link to="/login" className='nav-link'>Login</Link>
             </Nav.Item>
           </>

         }
        
         
       </Nav>
     
     </nav>
  </>)
};