import React, {  useEffect, useState } from 'react';
import '../App.css';
import { useNavigate } from 'react-router-dom';
import Header from '../Layouts/Header';




function Login() {
  const [email, setEmail] = useState('');
  const [password,setPassword] = useState('');
  const [message, setMessage] = useState('');
  const [errors, setErrors] = useState({});
  const navigate = useNavigate();
  useEffect(() => {
    if(localStorage.getItem('user-info')){
      navigate('/');
    }
  }, [navigate]);
  async function signIn() {
    const item = {email, password};
    try{
      const result= await fetch("http://127.0.0.1:8000/api/login",{
        method: 'POST',
        body:JSON.stringify(item),
        headers: {
          "Content-Type":'application/json',
          "Accept": 'application/json',
        }
      });
      if(result.ok)
      {
        const resuldata = await result.json();
        localStorage.setItem('user-info',JSON.stringify(resuldata));
        console.warn(resuldata);
        navigate('/');
      }else{
        const errorData = await result.json();
        if (errorData.message === "Unauthorized") {
          console.warn(errorData.message);
          setErrors({ email: ["Email non trouvé."] });
        } else {
          setErrors(errorData.errors || {});
        }
        
        setMessage('Une erreur est survenue.');
      }
    }catch(error){
      console.error('There was an error!',error);
      setMessage('Erreur de connexion au serveur.');
    }
    
  }
return (
  <>
   <Header/>
    <div className='col-sm-6 offset-sm-3 login'>
      <h1>Connection</h1>
      <input type='email' className='form-control' placeholder='Email' value={email} onChange={(e) => setEmail(e.target.value)}/><br />
      <input type='password' className='form-control' placeholder='Mot de passe' value={password} onChange={(e) => setPassword(e.target.value)}/> <br />
      <button onClick={signIn} className='btn btn-primary'>Login</button><br />
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
);
}

export default Login;
