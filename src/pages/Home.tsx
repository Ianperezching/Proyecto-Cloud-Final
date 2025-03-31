import MainBanner from "../common/MainBanner.tsx";

function Home() {

    return (
        <div>
        <MainBanner />
        <section style={{
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
            justifyContent: 'center',
            textAlign: 'center',
            backgroundColor: '#f0f8ff',
            padding: '20px',
            borderRadius: '10px',
            marginTop: '20px'
        }}>
            
            <h2 style={{ color: '#333' }}>Sobre mí</h2>
            <p style={{ color: '#555', fontSize: '18px' }}>
                <strong>Nombre:</strong> Ian marcelo Perez Ching<br />
                <strong>Edad:</strong> 21 años<br />
                <strong>Carrera:</strong> diseño y desarrollo de simuladores y videojuegos<br />
            </p>
        </section>
    </div>
    );
}


export default Home