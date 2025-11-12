import React, { useEffect, useState, useCallback } from 'react';
import { View, Text, FlatList, TouchableOpacity, StyleSheet, Alert, ActivityIndicator, RefreshControl } from 'react-native';
import client from '../api/client';

export default function OrdersScreen({ route }: any) {
  const { user } = route.params;
  const [orders, setOrders] = useState<any[]>([]);
  const [kitchenId, setKitchenId] = useState<string>('');
  const [isLoading, setIsLoading] = useState(false);
  const [isRefreshing, setIsRefreshing] = useState(false);

  useEffect(() => {
    // kitchenid from API is a CSV like '"1","2"' etc; adapt as needed
    if (user && user.kitchenid) setKitchenId(user.kitchenid.replace(/'/g, '').split(',')[0] || '');
    fetchOrders();
    
    // Set up auto-refresh every 30 seconds
    const interval = setInterval(fetchOrders, 30000);
    return () => clearInterval(interval);
  }, []);

  const fetchOrders = async (showLoadingIndicator = true) => {
    try {
      if (showLoadingIndicator) setIsLoading(true);
      
      const form = new FormData();
      form.append('id', user.id);
      form.append('kitchenid', kitchenId);

      const resp = await client.post('/index.php/V3/orderlist', form, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      if (resp.data && resp.data.status === 'success') {
        setOrders(resp.data.data.orderinfo || []);
      } else {
        Alert.alert('Error', resp.data?.message || 'Failed to fetch orders');
      }
    } catch (err: any) {
      Alert.alert('Network error', err.message);
    } finally {
      if (showLoadingIndicator) setIsLoading(false);
    }
  };

  const onRefresh = useCallback(() => {
    setIsRefreshing(true);
    fetchOrders(false).finally(() => setIsRefreshing(false));
  }, []);

  const markReady = async (order_id: string, ProductsID: string, varientid: string) => {
    try {
      const form = new FormData();
      form.append('Orderid', order_id);
      form.append('ProductsID', ProductsID);
      form.append('variantid', varientid);
      form.append('isready', '1');
      form.append('kitchenid', kitchenId);

      const resp = await client.post('/index.php/V3/foodisready', form, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      if (resp.data && resp.data.status === 'success') {
        Alert.alert('Success', 'Marked ready');
        // Refresh orders list
        fetchOrders(false);
      } else {
        Alert.alert('Error', resp.data?.message || 'Failed to update order status');
      }
    } catch (err: any) {
      Alert.alert('Network error', err.message);
    }
  };

  if (isLoading && !orders.length) {
    return (
      <View style={[styles.container, styles.centered]}>
        <ActivityIndicator size="large" color="#0000ff" />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Incoming Orders</Text>
      <FlatList
        data={orders}
        keyExtractor={(item: any) => item.order_id}
        refreshControl={
          <RefreshControl refreshing={isRefreshing} onRefresh={onRefresh} />
        }
        renderItem={({ item }) => (

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Incoming Orders</Text>
      <FlatList
        data={orders}
        keyExtractor={(item: any) => item.order_id}
        renderItem={({ item }) => (
          <View style={styles.card}>
            <Text style={styles.orderId}>Order: {item.order_id}</Text>
            <Text>Customer: {item.CustomerName}</Text>
            <Text>Table: {item.TableName}</Text>
            {item.iteminfo && item.iteminfo.map((it: any, idx: number) => (
              <View key={idx} style={styles.itemRow}>
                <Text>{it.ProductName} x{it.Itemqty}</Text>
                <TouchableOpacity onPress={() => markReady(item.order_id, it.ProductsID, it.Varientid)} style={styles.readyButton}>
                  <Text style={{color: 'white'}}>Mark Ready</Text>
                </TouchableOpacity>
              </View>
            ))}
          </View>
        )}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: { 
    flex: 1, 
    padding: 12 
  },
  centered: {
    justifyContent: 'center',
    alignItems: 'center'
  },
  title: { 
    fontSize: 20, 
    marginBottom: 8 
  },
  card: { 
    borderWidth: 1, 
    borderColor: '#ddd', 
    padding: 10, 
    marginBottom: 8, 
    borderRadius: 6 
  },
  orderId: { 
    fontWeight: 'bold' 
  },
  itemRow: { 
    flexDirection: 'row', 
    justifyContent: 'space-between', 
    alignItems: 'center', 
    marginTop: 6 
  },
  readyButton: { 
    backgroundColor: '#2e7d32', 
    padding: 6, 
    borderRadius: 4 
  }
});
