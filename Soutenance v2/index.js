import React, { useState } from 'react';
import { hash, compare } from 'bcryptjs';


























// Création/Vérification hash, salt
const PasswordVerifier = () => {
  const [password, setPassword] = useState('');
  const [hashedPassword, setHashedPassword] = useState('');
  const [salt, setSalt] = useState('');

  const generateSaltAndHash = async () => {
    // Générer un salt
    const generatedSalt = await hash('MeilleurSalt', 10); // Le deuxième paramètre est le coût du hachage

    // Sauvegarder le salt
    setSalt(generatedSalt);

    // Hacher le mot de passe avec le salt
    const hashed = await hash(password, generatedSalt);
    setHashedPassword(hashed);

    // Vérifier le mot de passe
    const isMatch = await compare(password, hashed);
    console.log('Mot de passe vérifié:', isMatch);
  };

  return (
    <div>
      <label>
        Mot de passe:
        <input
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
      </label>
      <button onClick={generateSaltAndHash}>Vérifier et hacher</button>

      <div>
        <p>Sel (salt): {salt}</p>
        <p>Mot de passe haché: {hashedPassword}</p>
      </div>
    </div>
  );
};

export default PasswordVerifier;

























const jwt = require('jsonwebtoken');

const generateJWT = () => {
  // Test variables du payload
  const userId = '123';
  const firstName = 'Marc';
  const lastName = 'Assin';
  const email = 'marc.Assin@pouet.com';

  // Date d'expiration du token (10 minutes)
  const expirationTime = Math.floor(Date.now() / 1000) + 600;

  // Création du payload du JWT
  const payload = {
    id: userId,
    firstname: firstName,
    lastname: lastName,
    email: email,
    exp: expirationTime,
  };

  // Clé secrète pour signer le JWT 
  // Il faudra que je remplace par la variable qui contient la clé definitive
  const secretKey = 'cleIndechiffrableDuFutur';

  // Génération du JWT
  const token = jwt.sign(payload, secretKey);

  return token;
};

// Appel de la fonction pour générer le JWT
// Une fois finie, faudra supprimer le consoleLog
const generatedToken = generateJWT();
console.log('JWT généré:', generatedToken);
