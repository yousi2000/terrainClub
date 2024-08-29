import React from 'react';
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import Header from "../Layouts/Header";

function Register(){

  const navigate = useNavigate();
  useEffect(() => {
    if(localStorage.getItem('user-info')){
      navigate('/login');
    }
  }, [navigate]);

  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [message, setmessage] = useState('');
  const [errors, setErrors] = useState({});
  async function signUp() {
    const item = { name, email, password};
    try{
      const response = await fetch("http://127.0.0.1:8000/api/register",
        {
          method:'POST',
          body: JSON.stringify(item),
          headers:{
            "Content-Type": 'application/json',
            "Accept": 'application/json',
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
          }
        }
      );
      if(response.ok)
      {
        const res = await response.json();
        localStorage.setItem('user-info', JSON.stringify(res));
        setmessage('Inscription réussie !');
        setTimeout(() => {
          navigate("/login");
        },2000);
      }else{
        const errorData = await response.json();
        setErrors(errorData.errors);
        setmessage('Une erreur est survenue.');
      }

    }catch(error){
      console.error('There was an error!',error);
      setmessage('Erreur de connexion au serveur.');
    }
    
  }
  return (
    <>
    <Header/>
    <div className='col-sm-6 offset-sm-3 signup'>
    <h1>Inscription</h1>
    <input type="text" className="form-control" placeholder="Nom" value={name} onChange={(e) => setName(e.target.value)}/> <br/>
    <input type="email" className="form-control" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)}/> <br/>
    <input type="password" className="form-control" placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)}/> <br/>
    <button className="btn btn-success" onClick={signUp}>S'inscrire</button>   <br/>
    {message && <p>{message}</p>}
      {Object.keys(errors).length > 0 && (
        <ul>
          {Object.keys(errors).map((key) => (
              <li key={key}>{errors[key][0]}</li>
          ))
          }
        </ul>
      )}
    </div> 
    </>
  )
}
export default Register;