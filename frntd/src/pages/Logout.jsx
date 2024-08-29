import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

function Logout() {
  const navigate = useNavigate();

  useEffect(() => {
    async function handleLogout() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/logout", {
          method: 'POST',
          headers: {
            "Content-Type": 'application/json',
            "Accept": 'application/json',
            "Authorization": `Bearer ${JSON.parse(localStorage.getItem('user-info')).token}`
          }
        });

        if (response.ok) {
          localStorage.removeItem('user-info');
          navigate("/");
        } else {
          console.error('Logout failed');
        }
      } catch (error) {
        console.error('There was an error!', error);
      }
    }

    handleLogout();
  }, [navigate]);

  return (
    <div>
      <h2>Logging out...</h2>
    </div>
  );
}

export default Logout;
