export interface Category {
  CategoryID: string;
  Name: string;
  categoryimage?: string;
}

export interface FoodItem {
  ProductsID: string;
  ProductName: string;
  ProductImage?: string;
  price?: number | string;
  variantid?: string;
}
