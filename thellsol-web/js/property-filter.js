// Script para filtrar propiedades en la página de comprar
// Archivo: js/property-filter.js

document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos del DOM
    const zonaSelect = document.getElementById('zona');
    const tipoSelect = document.getElementById('tipo');
    const precioSelect = document.getElementById('precio');
    const dormitoriosSelect = document.getElementById('dormitorios');
    const buscarBtn = document.querySelector('.filtros-btn');
    const cardsContainer = document.querySelector('.cards');
    
    // Obtener todas las propiedades (ya cargadas por PHP)
    const allProperties = Array.from(document.querySelectorAll('.card')).map(card => {
        return {
            element: card,
            title: card.querySelector('.card-title').textContent.toLowerCase(),
            location: card.querySelector('.card-zona').textContent.toLowerCase(),
            price: parseInt(card.querySelector('.card-precio').textContent.replace(/[^\d]/g, '')),
            description: card.querySelector('.card-desc').textContent.toLowerCase()
        };
    });
    
    // Función para filtrar propiedades
    function filterProperties() {
        const zona = zonaSelect.value.toLowerCase();
        const tipo = tipoSelect.value.toLowerCase();
        const precio = precioSelect.value;
        const dormitorios = dormitoriosSelect.value;
        
        allProperties.forEach(property => {
            let show = true;
            
            // Filtro por zona
            if (zona && !property.location.includes(zona)) {
                show = false;
            }
            
            // Filtro por tipo (basado en descripción)
            if (tipo && !property.description.includes(tipo)) {
                show = false;
            }
            
            // Filtro por precio
            if (precio) {
                const [minPrice, maxPrice] = precio.split('-').map(p => {
                    if (p === '+') return Infinity;
                    return parseInt(p);
                });
                
                if (property.price < minPrice || (maxPrice !== Infinity && property.price > maxPrice)) {
                    show = false;
                }
            }
            
            // Filtro por dormitorios
            if (dormitorios) {
                const dormCount = parseInt(dormitorios);
                const descText = property.description;
                
                if (dormCount === 5) {
                    // 5+ dormitorios
                    if (!descText.includes('5') && !descText.includes('6') && !descText.includes('7') && !descText.includes('8') && !descText.includes('9')) {
                        show = false;
                    }
                } else {
                    // Número específico de dormitorios
                    if (!descText.includes(dormCount.toString())) {
                        show = false;
                    }
                }
            }
            
            // Mostrar u ocultar la propiedad
            property.element.style.display = show ? 'flex' : 'none';
        });
        
        // Mostrar mensaje si no hay resultados
        const visibleProperties = allProperties.filter(p => p.element.style.display !== 'none');
        showNoResultsMessage(visibleProperties.length === 0);
    }
    
    // Función para mostrar mensaje de no resultados
    function showNoResultsMessage(show) {
        let noResultsMsg = document.getElementById('no-results-message');
        
        if (show) {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'no-results-message';
                noResultsMsg.style.cssText = `
                    text-align: center;
                    padding: 40px;
                    color: #666;
                    font-size: 1.1rem;
                    background: #f8f9fa;
                    border-radius: 8px;
                    margin: 20px 0;
                `;
                noResultsMsg.innerHTML = `
                    <h3>🔍 No se encontraron propiedades</h3>
                    <p>Intenta ajustar los filtros de búsqueda</p>
                `;
                cardsContainer.appendChild(noResultsMsg);
            }
        } else {
            if (noResultsMsg) {
                noResultsMsg.remove();
            }
        }
    }
    
    // Event listeners
    if (buscarBtn) {
        buscarBtn.addEventListener('click', filterProperties);
    }
    
    // Filtrado automático al cambiar cualquier filtro
    [zonaSelect, tipoSelect, precioSelect, dormitoriosSelect].forEach(select => {
        if (select) {
            select.addEventListener('change', filterProperties);
        }
    });
    
    // Función para limpiar filtros
    function clearFilters() {
        zonaSelect.value = '';
        tipoSelect.value = '';
        precioSelect.value = '';
        dormitoriosSelect.value = '';
        
        // Mostrar todas las propiedades
        allProperties.forEach(property => {
            property.element.style.display = 'flex';
        });
        
        showNoResultsMessage(false);
    }
    
    // Agregar botón de limpiar filtros
    const clearBtn = document.createElement('button');
    clearBtn.textContent = 'LIMPIAR FILTROS';
    clearBtn.style.cssText = `
        background: #6c757d;
        color: #fff;
        font-weight: 600;
        margin-top: 12px;
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        cursor: pointer;
        width: 100%;
    `;
    
    clearBtn.addEventListener('mouseenter', function() {
        this.style.background = '#5a6268';
        this.style.transform = 'translateY(-1px)';
    });
    
    clearBtn.addEventListener('mouseleave', function() {
        this.style.background = '#6c757d';
        this.style.transform = 'translateY(0)';
    });
    
    clearBtn.addEventListener('click', clearFilters);
    
    // Insertar botón después del botón de buscar
    if (buscarBtn && buscarBtn.parentNode) {
        buscarBtn.parentNode.insertBefore(clearBtn, buscarBtn.nextSibling);
    }
    
    // Función para mostrar contador de resultados
    function updateResultsCounter() {
        const visibleProperties = allProperties.filter(p => p.element.style.display !== 'none');
        const counterElement = document.getElementById('results-counter');
        
        if (!counterElement) {
            const counter = document.createElement('div');
            counter.id = 'results-counter';
            counter.style.cssText = `
                text-align: center;
                margin-bottom: 20px;
                color: #666;
                font-size: 0.9rem;
            `;
            
            const resultadosTitulo = document.querySelector('.resultados-titulo');
            if (resultadosTitulo) {
                resultadosTitulo.parentNode.insertBefore(counter, resultadosTitulo.nextSibling);
            }
        }
        
        const counter = document.getElementById('results-counter');
        if (counter) {
            counter.textContent = `${visibleProperties.length} propiedad${visibleProperties.length !== 1 ? 'es' : ''} encontrada${visibleProperties.length !== 1 ? 's' : ''}`;
        }
    }
    
    // Actualizar contador inicial
    updateResultsCounter();
    
    // Modificar la función filterProperties para incluir el contador
    const originalFilterProperties = filterProperties;
    filterProperties = function() {
        originalFilterProperties();
        updateResultsCounter();
    };
});

// Función para ordenar propiedades
function sortProperties(criteria) {
    const cardsContainer = document.querySelector('.cards');
    const cards = Array.from(cardsContainer.querySelectorAll('.card'));
    
    cards.sort((a, b) => {
        let aValue, bValue;
        
        switch (criteria) {
            case 'price-asc':
                aValue = parseInt(a.querySelector('.card-precio').textContent.replace(/[^\d]/g, ''));
                bValue = parseInt(b.querySelector('.card-precio').textContent.replace(/[^\d]/g, ''));
                return aValue - bValue;
                
            case 'price-desc':
                aValue = parseInt(a.querySelector('.card-precio').textContent.replace(/[^\d]/g, ''));
                bValue = parseInt(b.querySelector('.card-precio').textContent.replace(/[^\d]/g, ''));
                return bValue - aValue;
                
            case 'name-asc':
                aValue = a.querySelector('.card-title').textContent.toLowerCase();
                bValue = b.querySelector('.card-title').textContent.toLowerCase();
                return aValue.localeCompare(bValue);
                
            case 'location-asc':
                aValue = a.querySelector('.card-zona').textContent.toLowerCase();
                bValue = b.querySelector('.card-zona').textContent.toLowerCase();
                return aValue.localeCompare(bValue);
                
            default:
                return 0;
        }
    });
    
    // Reordenar elementos en el DOM
    cards.forEach(card => cardsContainer.appendChild(card));
}

// Agregar selector de ordenación si no existe
document.addEventListener('DOMContentLoaded', function() {
    const resultadosTitulo = document.querySelector('.resultados-titulo');
    
    if (resultadosTitulo && !document.getElementById('sort-selector')) {
        const sortContainer = document.createElement('div');
        sortContainer.style.cssText = `
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        `;
        
        const sortLabel = document.createElement('label');
        sortLabel.textContent = 'Ordenar por:';
        sortLabel.style.cssText = `
            font-weight: 600;
            margin-right: 10px;
        `;
        
        const sortSelect = document.createElement('select');
        sortSelect.id = 'sort-selector';
        sortSelect.style.cssText = `
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background: white;
            font-size: 14px;
        `;
        
        sortSelect.innerHTML = `
            <option value="">Sin ordenar</option>
            <option value="price-asc">Precio: Menor a Mayor</option>
            <option value="price-desc">Precio: Mayor a Menor</option>
            <option value="name-asc">Nombre: A-Z</option>
            <option value="location-asc">Ubicación: A-Z</option>
        `;
        
        sortSelect.addEventListener('change', function() {
            if (this.value) {
                sortProperties(this.value);
            }
        });
        
        sortContainer.appendChild(sortLabel);
        sortContainer.appendChild(sortSelect);
        
        resultadosTitulo.parentNode.insertBefore(sortContainer, resultadosTitulo.nextSibling);
    }
});
