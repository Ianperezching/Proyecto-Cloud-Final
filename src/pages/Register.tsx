import React, { useState } from 'react';
import './Login.css';

const Register: React.FC = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [email, setEmail] = useState('');
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setSuccess('');
    try {
      const response = await fetch('/XAPP/create_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&email=${encodeURIComponent(email)}`
      });
      const data = await response.json();
      if (data.success) {
        setSuccess('Usuario registrado correctamente');
      } else {
        setError(data.message || 'Error al registrar');
      }
    } catch {
      setError('Error de conexión con el servidor');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="login-container">
      <form className="login-form" onSubmit={handleSubmit}>
        <h2>Registrarse</h2>
        <input type="text" placeholder="Usuario" value={username} onChange={e => setUsername(e.target.value)} required />
        <input type="email" placeholder="Correo" value={email} onChange={e => setEmail(e.target.value)} required />
        <input type="password" placeholder="Contraseña" value={password} onChange={e => setPassword(e.target.value)} required />
        <button type="submit" disabled={loading}>{loading ? 'Registrando...' : 'Registrarse'}</button>
        {error && <div className="login-error">{error}</div>}
        {success && <div className="login-success">{success}</div>}
      </form>
    </div>
  );
};

export default Register;
