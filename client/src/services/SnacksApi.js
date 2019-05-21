import { HttpClient } from './HttpClient';

export class SnacksApi {
    static async getDefaultSnackMenu() {
        return HttpClient.get('/snacks/menu', {
            include: 'snacks.ingredients'
        });
    }

    static async getAvailableIngredients() {
        return HttpClient.get('/ingredients');
    }

    static async getPromotions() {
        return HttpClient.get('/promotions');
    }

    static async getCustomSnack(customSnackId) {
        return HttpClient.get(`/snacks/custom/${customSnackId}`);
    }

    static async addCustomSnackIngredient(customSnackId, ingredientId, quantity) {
        return HttpClient.post(`/snacks/custom/${customSnackId}/ingredients`, {
            ingredient_id: ingredientId,
            quantity
        });
    }

    static async removeCustomSnackIngredient(customSnackId, ingredientId, quantity) {
        return HttpClient.delete(`/snacks/custom/${customSnackId}/ingredients`, {
            ingredient_id: ingredientId,
            quantity
        });
    }

    static async createCustomSnack(customerId) {
        return HttpClient.post('/snacks/custom', {
            customer_id: customerId
        });
    }
}