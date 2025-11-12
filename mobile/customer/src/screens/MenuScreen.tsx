import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, FlatList, TouchableOpacity, ActivityIndicator, Image } from 'react-native';
import { getCategories, getFoodList } from '../services/api';
import { Category, FoodItem } from '../types';
import { useAuth } from '../context/AuthContext';

export default function MenuScreen() {
  const [categories, setCategories] = useState<Category[]>([]);
  const [foods, setFoods] = useState<FoodItem[]>([]);
  const [loadingCategories, setLoadingCategories] = useState(true);
  const [loadingFoods, setLoadingFoods] = useState(false);
  const [selectedCategory, setSelectedCategory] = useState<string>('1');

  const { user } = useAuth();

  useEffect(() => {
    loadCategories();
  }, []);

  useEffect(() => {
    if (selectedCategory) loadFoods(selectedCategory);
  }, [selectedCategory]);

  const loadCategories = async () => {
    try {
      setLoadingCategories(true);
      const customerId = user && (user.id || user.user_id || user.customer_id) ? String(user.id || user.user_id || user.customer_id) : '1';
      const resp = await getCategories(customerId, '');
      if (resp && resp.status === 'success') {
        const data = resp.data || [];
        setCategories(data);
        if (data && data.length > 0) setSelectedCategory(String(data[0].CategoryID));
      }
    } catch (err) {
      console.error('Category load failed', err);
    } finally {
      setLoadingCategories(false);
    }
  };

  const loadFoods = async (catId: string) => {
    try {
      setLoadingFoods(true);
      const customerId = user && (user.id || user.user_id || user.customer_id) ? String(user.id || user.user_id || user.customer_id) : '1';
      const resp = await getFoodList(customerId, catId);
      if (resp && resp.status === 'success') {
        // Appv1 returns foodinfo inside data.foodinfo or data depending on controller
        const data = resp.data && resp.data.foodinfo ? resp.data.foodinfo : resp.data || [];
        setFoods(data);
      }
    } catch (err) {
      console.error('Food load failed', err);
    } finally {
      setLoadingFoods(false);
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Menu</Text>

      {loadingCategories ? (
        <ActivityIndicator />
      ) : (
        <FlatList
          data={categories}
          horizontal
          keyExtractor={(item) => String(item.CategoryID)}
          renderItem={({ item }) => (
            <TouchableOpacity
              onPress={() => setSelectedCategory(String(item.CategoryID))}
              style={[styles.category, selectedCategory === String(item.CategoryID) && styles.categoryActive]}
            >
              {item.categoryimage ? (
                <Image source={{ uri: item.categoryimage }} style={styles.catImg} />
              ) : null}
              <Text style={styles.catText}>{item.Name}</Text>
            </TouchableOpacity>
          )}
        />
      )}

      <View style={{ flex: 1, marginTop: 12 }}>
        {loadingFoods ? (
          <ActivityIndicator />
        ) : (
          <FlatList
            data={foods}
            keyExtractor={(item) => String(item.ProductsID)}
            renderItem={({ item }) => (
              <View style={styles.foodItem}>
                {item.ProductImage ? <Image source={{ uri: item.ProductImage }} style={styles.foodImg} /> : null}
                <View style={{ flex: 1 }}>
                  <Text style={styles.foodName}>{item.ProductName}</Text>
                  <Text style={styles.foodPrice}>${item.price}</Text>
                </View>
              </View>
            )}
          />
        )}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, padding: 16, backgroundColor: '#fff' },
  title: { fontSize: 20, fontWeight: 'bold', marginBottom: 12 },
  category: { padding: 8, marginRight: 8, alignItems: 'center' },
  categoryActive: { backgroundColor: '#eee', borderRadius: 8 },
  catText: { fontSize: 14 },
  catImg: { width: 48, height: 48, borderRadius: 24, marginBottom: 6 },
  foodItem: { flexDirection: 'row', padding: 12, borderBottomWidth: 1, borderBottomColor: '#eee' },
  foodImg: { width: 64, height: 64, marginRight: 12 },
  foodName: { fontSize: 16, fontWeight: '600' },
  foodPrice: { marginTop: 6, color: '#666' },
});

