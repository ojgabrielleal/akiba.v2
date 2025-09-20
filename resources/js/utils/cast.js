import axios from 'axios';

export async function cast() {
    async function fetching() {
        try {
            const response = await axios.get('/api/cast/data');
            return response.data;
        } catch (error) {
            console.error('Error fetching cast data on akiba api:', error);
            throw error;
        }
    }

    // primeira chamada: retorna os dados
    const castReturn = await fetching();

    // inicia loop de atualização
    setInterval(() => {
        fetching().catch(() => {});
    }, 60 * 1000); // Atualiza a cada 60 segundos

    return castReturn; 
}
