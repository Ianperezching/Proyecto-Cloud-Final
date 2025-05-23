import { useEffect, useState } from "react";
import { Unity, useUnityContext } from "react-unity-webgl";

function Game4() {
  const [inputValue, setInputValue] = useState("");
  const [unityMessage, setUnityMessage] = useState<string | null>(null);

  const { unityProvider, sendMessage } = useUnityContext({
    loaderUrl: "Build Nave.loader.js",
    dataUrl: "Build Nave.data",
    frameworkUrl: "Build Nave.framework.js",
    codeUrl: "Build Nave.wasm",
  });

  // Evento 1: Reiniciar escena
  const handleRestartScene = () => {
    sendMessage("GameController", "ReloadCurrentScene");
  };

  // Evento 2: Enviar texto a Unity
  const handleSendTextToUnity = () => {
    sendMessage("GameController", "UpdateText", inputValue);
  };

  // Recibir mensajes desde Unity
  useEffect(() => {
    // Define la función global que Unity llamará
    (window as any).onUnityMessage = (param: string) => {
      setUnityMessage(param);
      console.log("Mensaje recibido de Unity:", param);
    };
    // Limpieza
    return () => {
      delete (window as any).onUnityMessage;
    };
  }, []);

  return (
    <div className="game-container">
      <h1>Game 4</h1>
      <Unity 
        unityProvider={unityProvider}
        className="unity-canvas"
        tabIndex={-1}
      />
      
      <div className="controls">
        <input
          type="text"
          value={inputValue}
          onChange={(e) => {
            e.stopPropagation();
            setInputValue(e.target.value);
          }}
          placeholder="Escribe algo para Unity"
        />
        
        <button onClick={handleSendTextToUnity}>Enviar a Unity</button>
        <button onClick={handleRestartScene}>Reiniciar Escena</button>
      </div>
      
      <div style={{marginTop: "20px"}}>
        <strong>Mensaje recibido de Unity:</strong>
        <div style={{color: "#0f0"}}>{unityMessage}</div>
      </div>
    </div>
  );
}

export default Game4;