// API para gestionar propiedades con Supabase
const { createClient } = require('@supabase/supabase-js');

// Configurar Supabase
const supabaseUrl = process.env.SUPABASE_URL || 'https://hhfkutuhvsjfbrwozvdq.supabase.co';
const supabaseKey = process.env.SUPABASE_ANON_KEY || 'tu-anon-key';
const supabase = createClient(supabaseUrl, supabaseKey);

module.exports = async (req, res) => {
    // Configurar CORS
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

    if (req.method === 'OPTIONS') {
        res.status(200).end();
        return;
    }

    try {
        switch (req.method) {
            case 'GET':
                // Obtener todas las propiedades
                const { data: properties, error: getError } = await supabase
                    .from('Property')
                    .select('*')
                    .order('createdAt', { ascending: false });

                if (getError) throw getError;
                res.status(200).json(properties);
                break;

            case 'POST':
                // Crear nueva propiedad
                const { data: newProperty, error: postError } = await supabase
                    .from('Property')
                    .insert([req.body])
                    .select();

                if (postError) throw postError;
                res.status(201).json(newProperty[0]);
                break;

            default:
                res.status(405).json({ error: 'Método no permitido' });
        }
    } catch (error) {
        console.error('Error:', error);
        res.status(500).json({ error: 'Error interno del servidor' });
    }
};
