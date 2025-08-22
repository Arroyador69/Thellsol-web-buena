<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Conexión JavaScript - Supabase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            width: 270px;
            padding: 0 0 18px 0;
            margin: 12px;
            display: inline-block;
            vertical-align: top;
        }
        .card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            padding: 12px 18px 0 18px;
        }
        .card-title {
            font-weight: bold;
            font-size: 1rem;
            margin-bottom: 4px;
        }
        .card-zona, .card-desc {
            font-size: 0.92rem;
            color: #666;
            margin-bottom: 2px;
        }
        .card-precio {
            color: #0070f3;
            font-weight: bold;
            font-size: 1.1rem;
            margin: 8px 0 10px 0;
        }
        .card-btn {
            background: #0070f3;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 7px 18px;
            font-size: 0.95rem;
            cursor: pointer;
        }
        #loading {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #666;
        }
        #error-message {
            text-align: center;
            padding: 20px;
            color: red;
            font-weight: bold;
        }
        #properties-list {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test de Conexión JavaScript - Supabase</h1>
        <p>Esta versión usa JavaScript para conectar directamente desde el navegador, evitando las restricciones del servidor.</p>
        
        <div id="properties-container">
            <div id="loading">Cargando propiedades desde Supabase...</div>
            <div id="properties-list" style="display:none;"></div>
            <div id="error-message" style="display:none;"></div>
        </div>
    </div>

    <script>
    const SUPABASE_URL = 'https://spdwjdrlemselkqbxau.supabase.co';
    const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs';
    
    async function loadProperties() {
        try {
            console.log('Intentando conectar a Supabase...');
            const response = await fetch(SUPABASE_URL + "/rest/v1/Property?select=*&order=createdAt.desc", {
                method: "GET",
                headers: {
                    "apikey": SUPABASE_KEY,
                    "Authorization": "Bearer " + SUPABASE_KEY,
                    "Content-Type": "application/json"
                }
            });
            
            console.log('Respuesta recibida:', response.status);
            
            if (response.ok) {
                const properties = await response.json();
                console.log('Propiedades cargadas:', properties.length);
                displayProperties(properties);
            } else {
                throw new Error("HTTP " + response.status + " - " + response.statusText);
            }
        } catch (error) {
            console.error("Error:", error);
            document.getElementById("loading").style.display = "none";
            document.getElementById("error-message").innerHTML = "❌ Error al cargar propiedades: " + error.message;
            document.getElementById("error-message").style.display = "block";
        }
    }
    
    function displayProperties(properties) {
        const container = document.getElementById("properties-list");
        const loading = document.getElementById("loading");
        
        loading.style.display = "none";
        container.style.display = "block";
        
        if (properties.length === 0) {
            container.innerHTML = "<p>No hay propiedades disponibles en la base de datos.</p>";
            return;
        }
        
        let html = `<h2>Propiedades encontradas (${properties.length}):</h2>`;
        properties.forEach(property => {
            html += `
            <div class="card">
                <img src="${property.images ? JSON.parse(property.images)[0] : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'}" 
                     alt="${property.title}">
                <div class="card-body">
                    <h3 class="card-title">${property.title}</h3>
                    <p class="card-zona">${property.location}</p>
                    <p class="card-desc">
                        ${property.bedrooms ? property.bedrooms + " dormitorios" : ""}
                        ${property.bathrooms ? ", " + property.bathrooms + " baños" : ""}
                        ${property.area ? ", " + property.area + "m²" : ""}
                    </p>
                    <p class="card-precio">
                        ${new Intl.NumberFormat("es-ES").format(property.price)}€
                    </p>
                    <button class="card-btn">Ver Detalles</button>
                </div>
            </div>
            `;
        });
        
        container.innerHTML = html;
    }
    
    // Cargar propiedades cuando se carga la página
    document.addEventListener("DOMContentLoaded", loadProperties);
    </script>
</body>
</html>
