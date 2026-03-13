export async function getPortfolio(clientId) {
    const response = await fetch(`/api/v1/portfolio/${clientId}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    });

    if (!response.ok) {
        throw new Error("Erro ao buscar portfolio");
    }

    return await response.json();
}
