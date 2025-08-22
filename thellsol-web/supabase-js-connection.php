<?php
// Conexión a Supabase usando JavaScript (funciona en Hostinger)
// Archivo: supabase-js-connection.php

class SupabaseJSConnection {
    private $supabaseUrl;
    private $supabaseKey;
    
    public function __construct() {
        $this->supabaseUrl = 'https://spdwjdrlemselkqbxau.supabase.co';
        $this->supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNwZHdqZHJsZW1zZWxrcWJ4YXVlIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTU2MTU0MzcsImV4cCI6MjA3MTE5MTQzN30.BzX55tzKeSGEL9D7wgJG4M-DCcmQ3K4fZjcHR-LMnAs';
    }
    
    // Generar HTML con JavaScript para conectar a Supabase
    public function getPropertiesHTML() {
        $html = '
        <div id="properties-container">
            <div id="loading">Cargando propiedades...</div>
            <div id="properties-list" style="display:none;"></div>
            <div id="error-message" style="display:none; color: red;"></div>
        </div>
        
        <script>
        const SUPABASE_URL = "' . $this->supabaseUrl . '";
        const SUPABASE_KEY = "' . $this->supabaseKey . '";
        
        async function loadProperties() {
            try {
                const response = await fetch(SUPABASE_URL + "/rest/v1/Property?select=*&order=createdAt.desc", {
                    method: "GET",
                    headers: {
                        "apikey": SUPABASE_KEY,
                        "Authorization": "Bearer " + SUPABASE_KEY,
                        "Content-Type": "application/json"
                    }
                });
                
                if (response.ok) {
                    const properties = await response.json();
                    displayProperties(properties);
                } else {
                    throw new Error("HTTP " + response.status);
                }
            } catch (error) {
                console.error("Error:", error);
                document.getElementById("loading").style.display = "none";
                document.getElementById("error-message").innerHTML = "Error al cargar propiedades: " + error.message;
                document.getElementById("error-message").style.display = "block";
            }
        }
        
        function displayProperties(properties) {
            const container = document.getElementById("properties-list");
            const loading = document.getElementById("loading");
            
            loading.style.display = "none";
            container.style.display = "block";
            
            if (properties.length === 0) {
                container.innerHTML = "<p>No hay propiedades disponibles.</p>";
                return;
            }
            
            let html = "";
            properties.forEach(property => {
                html += `
                <div class="card" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; width: 270px; padding: 0 0 18px 0; margin: 12px; display: inline-block;">
                    <img src="${property.images ? JSON.parse(property.images)[0] : 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'}" 
                         style="width: 100%; height: 140px; object-fit: cover; border-radius: 8px 8px 0 0;" 
                         alt="${property.title}">
                    <div style="padding: 12px 18px 0 18px;">
                        <h3 style="font-weight: bold; font-size: 1rem; margin-bottom: 4px;">${property.title}</h3>
                        <p style="font-size: 0.92rem; color: #666; margin-bottom: 2px;">${property.location}</p>
                        <p style="font-size: 0.92rem; color: #666; margin-bottom: 2px;">
                            ${property.bedrooms ? property.bedrooms + " dormitorios" : ""}
                            ${property.bathrooms ? ", " + property.bathrooms + " baños" : ""}
                            ${property.area ? ", " + property.area + "m²" : ""}
                        </p>
                        <p style="color: #0070f3; font-weight: bold; font-size: 1.1rem; margin: 8px 0 10px 0;">
                            ${new Intl.NumberFormat("es-ES").format(property.price)}€
                        </p>
                        <button style="background: #0070f3; color: #fff; border: none; border-radius: 4px; padding: 7px 18px; font-size: 0.95rem; cursor: pointer;">
                            Ver Detalles
                        </button>
                    </div>
                </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Cargar propiedades cuando se carga la página
        document.addEventListener("DOMContentLoaded", loadProperties);
        </script>';
        
        return $html;
    }
}

// Función helper para usar en las páginas
function displayPropertiesJS($properties = []) {
    $supabase = new SupabaseJSConnection();
    return $supabase->getPropertiesHTML();
}
?>
