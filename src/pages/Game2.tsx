import React, { useState } from "react";

function Game2() {
  const [inputValue, setInputValue] = useState("");

  return (
    <div>
      <h1>Game 2</h1>
      <p>This is the second game.</p>
      <input
        type="text"
        value={inputValue}
        onChange={(e) => setInputValue(e.target.value)}
        placeholder="Escribe aquí..."
      />
    </div>
  );
}
export default Game2;