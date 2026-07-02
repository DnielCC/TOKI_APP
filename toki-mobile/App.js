import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  Image,
  TextInput,
  TouchableOpacity,
  ScrollView,
  SafeAreaView,
  KeyboardAvoidingView,
  Platform,
  Alert,
} from 'react-native';
import * as Speech from 'expo-speech';
import AsyncStorage from '@react-native-async-storage/async-storage';

const CATEGORIES = [
  {
    id: 'personas',
    name: 'Personas y Relaciones',
    pictos: [
      { id: 'abuela', label: 'abuela' },
      { id: 'abuelo', label: 'abuelo' },
      { id: 'amigo', label: 'amigo' },
      { id: 'madre', label: 'madre' },
      { id: 'padre', label: 'padre' },
      { id: 'maestro', label: 'maestro' },
      { id: 'hermana', label: 'hermana' },
      { id: 'hermano', label: 'hermano' },
      { id: 'doctor', label: 'doctor' },
      { id: 'enfermera', label: 'enfermera' },
      { id: 'dentista', label: 'dentista' },
    ],
  },
  {
    id: 'emociones',
    name: 'Emociones y Estados',
    pictos: [
      { id: 'feliz', label: 'feliz' },
      { id: 'triste', label: 'triste' },
      { id: 'enojado', label: 'enojado' },
      { id: 'nervioso', label: 'nervioso' },
      { id: 'sorpresa', label: 'sorpresa' },
      { id: 'reir', label: 'reir' },
      { id: 'llorar', label: 'llorar' },
      { id: 'miedo', label: 'miedo' },
      { id: 'cansado', label: 'cansado' },
      { id: 'hambre', label: 'hambre' },
      { id: 'sed', label: 'sed' },
      { id: 'dolor', label: 'dolor' },
      { id: 'fiebre', label: 'fiebre' },
    ],
  },
  {
    id: 'acciones',
    name: 'Acciones Diarias',
    pictos: [
      { id: 'abrir', label: 'abrir' },
      { id: 'cerrar', label: 'cerrar' },
      { id: 'agarrar', label: 'agarrar' },
      { id: 'caminar', label: 'caminar' },
      { id: 'correr', label: 'correr' },
      { id: 'saltar', label: 'saltar' },
      { id: 'tomar', label: 'tomar' },
      { id: 'beber', label: 'beber' },
      { id: 'comer', label: 'comer' },
      { id: 'cocinar', label: 'cocinar' },
      { id: 'despertar', label: 'despertar' },
      { id: 'dormir', label: 'dormir' },
      { id: 'lavar_manos', label: 'lavar manos' },
      { id: 'lavar_dientes', label: 'lavar dientes' },
      { id: 'limpiar', label: 'limpiar' },
      { id: 'hablar', label: 'hablar' },
      { id: 'escuchar', label: 'escuchar' },
      { id: 'mirar', label: 'mirar' },
      { id: 'ver', label: 'ver' },
      { id: 'escribir', label: 'escribir' },
      { id: 'dibujar', label: 'dibujar' },
      { id: 'estudiar', label: 'estudiar' },
      { id: 'trabajar', label: 'trabajar' },
      { id: 'jugar', label: 'jugar' },
      { id: 'venir', label: 'regresar' },
      { id: 'ir', label: 'ir' },
    ],
  },
  {
    id: 'lugares',
    name: 'Lugares y Espacios',
    pictos: [
      { id: 'casa', label: 'casa' },
      { id: 'cocina', label: 'cocina' },
      { id: 'dormitorio', label: 'dormitorio' },
      { id: 'escuela', label: 'escuela' },
      { id: 'biblioteca', label: 'biblioteca' },
      { id: 'ciudad', label: 'ciudad' },
      { id: 'parque', label: 'parque' },
      { id: 'playa', label: 'playa' },
      { id: 'restaurante', label: 'restaurante' },
      { id: 'hospital', label: 'hospital' },
      { id: 'farmacia', label: 'farmacia' },
      { id: 'supermercado', label: 'supermercado' },
    ],
  },
  {
    id: 'objetos',
    name: 'Objetos y Alimentos',
    pictos: [
      { id: 'agua', label: 'agua' },
      { id: 'leche', label: 'leche' },
      { id: 'pan', label: 'pan' },
      { id: 'fruta', label: 'fruta' },
      { id: 'comida', label: 'comida' },
      { id: 'desayuno', label: 'desayuno' },
      { id: 'almuerzo', label: 'almuerzo' },
      { id: 'cena', label: 'cena' },
      { id: 'libro', label: 'libro' },
      { id: 'computadora', label: 'computadora' },
      { id: 'diccionario', label: 'diccionario' },
      { id: 'medicina', label: 'medicina' },
      { id: 'pastilla', label: 'pastilla' },
      { id: 'termometro', label: 'termometro' },
    ],
  },
  {
    id: 'actividades',
    name: 'Actividades Específicas',
    pictos: [
      { id: 'arte', label: 'arte' },
      { id: 'ciencias', label: 'ciencias' },
      { id: 'matematicas', label: 'matemáticas' },
      { id: 'caminar', label: 'caminar' },
      { id: 'bailar', label: 'bailar' },
      { id: 'trabajar', label: 'trabajar' },
      { id: 'vacuna', label: 'vacuna' },
      { id: 'baño', label: 'baño' },
      { id: 'higiene', label: 'bañarme' },
    ],
  },
];

const PICTOS = CATEGORIES.flatMap((category) => category.pictos);

const getPictoPath = (id) => {
  const pictos = {
    abrir: require('./assets/pictos/abrir.png'),
    abuela: require('./assets/pictos/abuela.png'),
    abuelo: require('./assets/pictos/abuelo.png'),
    agarrar: require('./assets/pictos/agarrar.png'),
    agua: require('./assets/pictos/agua.png'),
    almuerzo: require('./assets/pictos/almuerzo.png'),
    ambulancia: require('./assets/pictos/ambulancia.png'),
    amigo: require('./assets/pictos/amigo.png'),
    amor: require('./assets/pictos/amor.png'),
    arte: require('./assets/pictos/arte.png'),
    bailar: require('./assets/pictos/bailar.png'),
    baño: require('./assets/pictos/baño.png'),
    beber: require('./assets/pictos/beber.png'),
    biblioteca: require('./assets/pictos/biblioteca.png'),
    caminar: require('./assets/pictos/caminar.png'),
    cansado: require('./assets/pictos/cansado.png'),
    casa: require('./assets/pictos/casa.png'),
    cena: require('./assets/pictos/cena.png'),
    cerrar: require('./assets/pictos/cerrar.png'),
    ciencias: require('./assets/pictos/ciencias.png'),
    ciudad: require('./assets/pictos/ciudad.png'),
    cocina: require('./assets/pictos/cocina.png'),
    cocinar: require('./assets/pictos/cocinar.png'),
    comer: require('./assets/pictos/comer.png'),
    comida: require('./assets/pictos/comida.png'),
    computadora: require('./assets/pictos/computadora.png'),
    correr: require('./assets/pictos/correr.png'),
    dar: require('./assets/pictos/dar.png'),
    dentista: require('./assets/pictos/dentista.png'),
    desayuno: require('./assets/pictos/desayuno.png'),
    despertar: require('./assets/pictos/despertar.png'),
    dibujar: require('./assets/pictos/dibujar.png'),
    diccionario: require('./assets/pictos/diccionario.png'),
    doctor: require('./assets/pictos/doctor.png'),
    dolor: require('./assets/pictos/dolor.png'),
    dormir: require('./assets/pictos/dormir.png'),
    dormitorio: require('./assets/pictos/dormitorio.png'),
    enfermera: require('./assets/pictos/enfermera.png'),
    enfermo: require('./assets/pictos/enfermo.png'),
    enojado: require('./assets/pictos/enojado.png'),
    escribir: require('./assets/pictos/escribir.png'),
    escuchar: require('./assets/pictos/escuchar.png'),
    escuela: require('./assets/pictos/escuela.png'),
    estudiar: require('./assets/pictos/estudiar.png'),
    farmacia: require('./assets/pictos/farmacia.png'),
    feliz: require('./assets/pictos/feliz.png'),
    fiebre: require('./assets/pictos/fiebre.png'),
    fruta: require('./assets/pictos/fruta.png'),
    hablar: require('./assets/pictos/hablar.png'),
    hambre: require('./assets/pictos/hambre.png'),
    herida: require('./assets/pictos/herida.png'),
    hermana: require('./assets/pictos/hermana.png'),
    hermano: require('./assets/pictos/hermano.png'),
    higiene: require('./assets/pictos/higiene.png'),
    hospital: require('./assets/pictos/hospital.png'),
    ir: require('./assets/pictos/ir.png'),
    jugar: require('./assets/pictos/jugar.png'),
    lavar_dientes: require('./assets/pictos/lavar_dientes.png'),
    lavar_manos: require('./assets/pictos/lavar_manos.png'),
    lavar_platos: require('./assets/pictos/lavar_platos.png'),
    lavar_ropa: require('./assets/pictos/lavar_ropa.png'),
    leche: require('./assets/pictos/leche.png'),
    leer: require('./assets/pictos/leer.png'),
    libro: require('./assets/pictos/libro.png'),
    limpiar: require('./assets/pictos/limpiar.png'),
    llorar: require('./assets/pictos/llorar.png'),
    madre: require('./assets/pictos/madre.png'),
    maestro: require('./assets/pictos/maestro.png'),
    matematicas: require('./assets/pictos/matematicas.png'),
    medicina: require('./assets/pictos/medicina.png'),
    miedo: require('./assets/pictos/miedo.png'),
    mirar: require('./assets/pictos/mirar.png'),
    nervioso: require('./assets/pictos/nervioso.png'),
    padre: require('./assets/pictos/padre.png'),
    pan: require('./assets/pictos/pan.png'),
    parque: require('./assets/pictos/parque.png'),
    pastilla: require('./assets/pictos/pastilla.png'),
    playa: require('./assets/pictos/playa.png'),
    quiero: require('./assets/pictos/quiero.png'),
    reir: require('./assets/pictos/reir.png'),
    restaurante: require('./assets/pictos/restaurante.png'),
    saltar: require('./assets/pictos/saltar.png'),
    sed: require('./assets/pictos/sed.png'),
    sorpresa: require('./assets/pictos/sorpresa.png'),
    supermercado: require('./assets/pictos/supermercado.png'),
    termometro: require('./assets/pictos/termometro.png'),
    tomar: require('./assets/pictos/tomar.png'),
    tos: require('./assets/pictos/tos.png'),
    trabajar: require('./assets/pictos/trabajar.png'),
    triste: require('./assets/pictos/triste.png'),
    vacuna: require('./assets/pictos/vacuna.png'),
    venir: require('./assets/pictos/venir.png'),
    ver: require('./assets/pictos/ver.png'),
  };
  return pictos[id];
};

const generatePhrase = (selectedPictos) => {
  if (selectedPictos.length === 0) return '';

  const picto = selectedPictos[0];
  const { id, label } = picto;

  switch (id) {
    case 'feliz':
    case 'triste':
    case 'enojado':
    case 'nervioso':
    case 'cansado':
      return `Estoy ${label}`;
    case 'sorpresa':
      return 'Estoy sorprendido/a';
    case 'reir':
      return 'Estoy riendo';
    case 'llorar':
      return 'Estoy llorando';
    case 'miedo':
    case 'dolor':
    case 'fiebre':
    case 'tos':
    case 'hambre':
    case 'sed':
      return `Tengo ${label}`;
    case 'bailar':
    case 'caminar':
    case 'cocinar':
    case 'despertar':
    case 'dibujar':
    case 'escribir':
    case 'estudiar':
    case 'jugar':
    case 'leer':
    case 'trabajar':
      return `Quiero ${label}`;
    case 'abuela':
    case 'abuelo':
    case 'amigo':
    case 'hermana':
    case 'hermano':
    case 'madre':
    case 'maestro':
      return `Quiero ver a mi ${label}`;
    case 'padre':
      return 'Quiero ver a mi papá';
    case 'arte':
      return 'Quiero hacer arte';
    case 'ciencias':
    case 'matematicas':
      return `Quiero aprender ${label}`;
    case 'computadora':
    case 'diccionario':
      const article = id === 'computadora' ? 'la' : 'el';
      return `Quiero usar ${article} ${label}`;
    case 'libro':
      return 'Quiero un libro';
    case 'casa':
      return 'Quiero ir a casa';
    case 'cocina':
    case 'biblioteca':
    case 'ciudad':
    case 'dormitorio':
    case 'escuela':
    case 'farmacia':
    case 'hospital':
    case 'parque':
    case 'playa':
    case 'restaurante':
    case 'supermercado':
      const preposition =
        id === 'cocina' || id === 'ciudad' || id === 'escuela' || id === 'farmacia' || id === 'playa'
          ? 'a la'
          : 'al';
      return `Quiero ir ${preposition} ${label}`;
    case 'desayuno':
      return 'Quiero desayunar';
    case 'almuerzo':
      return 'Quiero almorzar';
    case 'cena':
      return 'Quiero cenar';
    case 'baño':
      return 'Quiero ir al baño';
    case 'lavar_manos':
      return 'Quiero lavarme las manos';
    case 'lavar_dientes':
      return 'Quiero lavarme los dientes';
    case 'doctor':
      return 'Quiero ir al doctor';
    case 'dentista':
      return 'Quiero ir al dentista';
    case 'enfermera':
      return 'Quiero ver a la enfermera';
    case 'pastilla':
      return 'Quiero una pastilla';
    case 'quiero':
      return 'Quiero algo';
    case 'termometro':
      return 'Me siento mal, tengo calentura';
    case 'vacuna':
      return 'Quiero vacunarme';
    default:
      return `Quiero ${label}`;
  }
};

export default function App() {
  const [activeCategory, setActiveCategory] = useState('all');
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedPictos, setSelectedPictos] = useState([]);
  const [phrase, setPhrase] = useState('');
  const [history, setHistory] = useState([]);
  const [showHistory, setShowHistory] = useState(false);

  useEffect(() => {
    const newPhrase = generatePhrase(selectedPictos);
    setPhrase(newPhrase);
  }, [selectedPictos]);

  useEffect(() => {
    loadHistory();
  }, []);

  const loadHistory = async () => {
    try {
      const stored = await AsyncStorage.getItem('toki_history');
      if (stored) {
        setHistory(JSON.parse(stored));
      }
    } catch (e) {
      console.error('Error loading history:', e);
    }
  };

  const saveHistory = async (newHistory) => {
    try {
      await AsyncStorage.setItem('toki_history', JSON.stringify(newHistory));
    } catch (e) {
      console.error('Error saving history:', e);
    }
  };

  const addPicto = (picto) => {
    setSelectedPictos([...selectedPictos, picto]);
  };

  const removePicto = (index) => {
    const newSelected = [...selectedPictos];
    newSelected.splice(index, 1);
    setSelectedPictos(newSelected);
  };

  const clearBuilder = () => {
    setSelectedPictos([]);
    setPhrase('');
  };

  const speakPhrase = () => {
    if (phrase) {
      Speech.speak(phrase, {
        language: 'es-ES',
        pitch: 1.1,
        rate: 0.9,
      });
    }
  };

  const savePhrase = () => {
    if (phrase) {
      const newHistory = [phrase, ...history.filter((h) => h !== phrase)].slice(0, 15);
      setHistory(newHistory);
      saveHistory(newHistory);
      Alert.alert('¡Guardado!', 'Frase guardada en el historial');
    }
  };

  const clearHistory = () => {
    Alert.alert(
      'Confirmar',
      '¿Estás seguro de que deseas borrar todo el historial?',
      [
        { text: 'Cancelar', style: 'cancel' },
        {
          text: 'Borrar',
          style: 'destructive',
          onPress: () => {
            setHistory([]);
            saveHistory([]);
          },
        },
      ]
    );
  };

  const selectHistoryPhrase = (phraseText) => {
    setPhrase(phraseText);
    setShowHistory(false);
  };

  const getFilteredPictos = () => {
    const categoriesToShow =
      activeCategory === 'all' ? CATEGORIES : CATEGORIES.filter((c) => c.id === activeCategory);

    return categoriesToShow.map((category) => ({
      ...category,
      pictos: category.pictos.filter((p) =>
        p.label.toLowerCase().includes(searchTerm.toLowerCase())
      ),
    })).filter((category) => category.pictos.length > 0);
  };

  const filteredCategories = getFilteredPictos();

  return (
    <SafeAreaView style={styles.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.keyboardView}
      >
        <View style={styles.header}>
          <Image source={require('./assets/toki-logo.png')} style={styles.logo} resizeMode="contain" />
          <Text style={styles.title}>TOKI</Text>
        </View>

        <ScrollView style={styles.content} showsVerticalScrollIndicator={false}>
          <View style={styles.builderSection}>
            <View style={styles.builderHeader}>
              <Text style={styles.sectionTitle}>Construye tu frase</Text>
              {selectedPictos.length > 0 && (
                <TouchableOpacity onPress={clearBuilder} style={styles.clearBtn}>
                  <Text style={styles.clearBtnText}>🗑️</Text>
                </TouchableOpacity>
              )}
            </View>
            <View style={styles.builder}>
              {selectedPictos.map((picto, index) => (
                <TouchableOpacity
                  key={index}
                  style={styles.token}
                  onPress={() => removePicto(index)}
                  activeOpacity={0.7}
                >
                  <Image source={getPictoPath(picto.id)} style={styles.tokenImage} />
                  <Text style={styles.tokenText}>{picto.label}</Text>
                </TouchableOpacity>
              ))}
              {selectedPictos.length === 0 && (
                <Text style={styles.placeholder}>Toca un pictograma para empezar</Text>
              )}
            </View>

            <View style={styles.phraseBar}>
              <View style={styles.phraseBox}>
                <Text style={styles.phraseText} numberOfLines={2}>
                  {phrase || 'Tu frase aparecerá aquí'}
                </Text>
              </View>
              <TouchableOpacity
                onPress={speakPhrase}
                style={[styles.actionBtn, styles.speakBtn]}
                activeOpacity={0.8}
              >
                <Text style={styles.actionBtnText}>🔊</Text>
              </TouchableOpacity>
              <TouchableOpacity
                onPress={savePhrase}
                style={[styles.actionBtn, styles.saveBtn]}
                activeOpacity={0.8}
                disabled={!phrase}
              >
                <Text style={styles.actionBtnText}>💾</Text>
              </TouchableOpacity>
            </View>
          </View>

          <View style={styles.gallerySection}>
            <View style={styles.searchContainer}>
              <TextInput
                style={styles.searchInput}
                placeholder="🔍 Buscar pictograma..."
                value={searchTerm}
                onChangeText={setSearchTerm}
              />
            </View>

            <ScrollView horizontal style={styles.categoryScroll} showsHorizontalScrollIndicator={false}>
              <TouchableOpacity
                style={[styles.filterBtn, activeCategory === 'all' && styles.filterBtnActive]}
                onPress={() => {
                  setActiveCategory('all');
                  setSearchTerm('');
                }}
              >
                <Text
                  style={[
                    styles.filterBtnText,
                    activeCategory === 'all' && styles.filterBtnTextActive,
                  ]}
                >
                  Todos
                </Text>
              </TouchableOpacity>
              {CATEGORIES.map((cat) => (
                <TouchableOpacity
                  key={cat.id}
                  style={[styles.filterBtn, activeCategory === cat.id && styles.filterBtnActive]}
                  onPress={() => {
                    setActiveCategory(cat.id);
                    setSearchTerm('');
                  }}
                >
                  <Text
                    style={[
                      styles.filterBtnText,
                      activeCategory === cat.id && styles.filterBtnTextActive,
                    ]}
                  >
                    {cat.name.split(' ')[0]}
                  </Text>
                </TouchableOpacity>
              ))}
            </ScrollView>

            {filteredCategories.map((category) => (
              <View key={category.id} style={styles.categorySection}>
                <Text style={styles.categoryTitle}>{category.name}</Text>
                <View style={styles.pictosGrid}>
                  {category.pictos.map((picto) => (
                    <TouchableOpacity
                      key={picto.id}
                      style={styles.picto}
                      onPress={() => addPicto(picto)}
                      activeOpacity={0.7}
                    >
                      <Image source={getPictoPath(picto.id)} style={styles.pictoImage} />
                      <Text style={styles.pictoLabel}>{picto.label}</Text>
                    </TouchableOpacity>
                  ))}
                </View>
              </View>
            ))}

            {filteredCategories.length === 0 && (
              <View style={styles.noResults}>
                <Text style={styles.noResultsEmoji}>🔍</Text>
                <Text style={styles.noResultsText}>
                  No se encontraron pictogramas para "{searchTerm}"
                </Text>
              </View>
            )}
          </View>

          <View style={styles.historySection}>
            <TouchableOpacity
              style={styles.historyToggle}
              onPress={() => setShowHistory(!showHistory)}
            >
              <Text style={styles.historyTitle}>Historial de frases</Text>
              <Text style={styles.historyToggleIcon}>{showHistory ? '▼' : '▶'}</Text>
            </TouchableOpacity>

            {showHistory && (
              <View style={styles.historyContent}>
                <View style={styles.historyHeader}>
                  <TouchableOpacity onPress={clearHistory} style={styles.clearHistoryBtn}>
                    <Text style={styles.clearHistoryText}>📋 Borrar</Text>
                  </TouchableOpacity>
                </View>
                {history.length === 0 ? (
                  <Text style={styles.noHistory}>No hay historial aún</Text>
                ) : (
                  history.map((item, index) => (
                    <TouchableOpacity
                      key={index}
                      style={styles.historyItem}
                      onPress={() => selectHistoryPhrase(item)}
                    >
                      <Text style={styles.historyItemText}>{item}</Text>
                    </TouchableOpacity>
                  ))
                )}
              </View>
            )}
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#cfeefb',
  },
  keyboardView: {
    flex: 1,
  },
  header: {
    backgroundColor: '#fdeaa6',
    padding: 20,
    alignItems: 'center',
    flexDirection: 'row',
    justifyContent: 'center',
    borderBottomWidth: 2,
    borderBottomColor: '#e0c060',
  },
  logo: {
    width: 60,
    height: 60,
    marginRight: 10,
  },
  title: {
    fontSize: 32,
    fontWeight: 'bold',
    color: '#2e6f73',
  },
  content: {
    flex: 1,
    padding: 16,
  },
  builderSection: {
    backgroundColor: '#fdeaa6',
    borderRadius: 16,
    padding: 16,
    marginBottom: 16,
  },
  builderHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 12,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#2a2a2a',
  },
  clearBtn: {
    padding: 4,
  },
  clearBtnText: {
    fontSize: 20,
  },
  builder: {
    minHeight: 100,
    backgroundColor: '#fff',
    borderRadius: 12,
    padding: 12,
    flexDirection: 'row',
    flexWrap: 'wrap',
    alignItems: 'flex-start',
    gap: 8,
  },
  placeholder: {
    color: '#999',
    fontStyle: 'italic',
    padding: 20,
  },
  token: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
    borderRadius: 999,
    paddingVertical: 8,
    paddingHorizontal: 12,
    borderWidth: 2,
    borderColor: '#d7d7d7',
    borderStyle: 'dashed',
  },
  tokenImage: {
    width: 28,
    height: 28,
    marginRight: 6,
  },
  tokenText: {
    fontSize: 14,
    color: '#2a2a2a',
  },
  phraseBar: {
    flexDirection: 'row',
    marginTop: 12,
    gap: 8,
  },
  phraseBox: {
    flex: 1,
    backgroundColor: '#fff',
    borderRadius: 999,
    paddingHorizontal: 16,
    paddingVertical: 12,
    justifyContent: 'center',
  },
  phraseText: {
    fontSize: 16,
    color: '#2a2a2a',
    flexWrap: 'wrap',
  },
  actionBtn: {
    width: 48,
    height: 48,
    borderRadius: 24,
    justifyContent: 'center',
    alignItems: 'center',
    elevation: 3,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
  },
  speakBtn: {
    backgroundColor: '#99e2a1',
  },
  saveBtn: {
    backgroundColor: '#e0e0e0',
  },
  actionBtnText: {
    fontSize: 24,
  },
  gallerySection: {
    backgroundColor: '#fff',
    borderRadius: 16,
    padding: 16,
    marginBottom: 16,
  },
  searchContainer: {
    marginBottom: 12,
  },
  searchInput: {
    backgroundColor: '#f8fafc',
    borderRadius: 12,
    paddingHorizontal: 16,
    paddingVertical: 12,
    fontSize: 16,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  categoryScroll: {
    marginBottom: 16,
  },
  filterBtn: {
    paddingHorizontal: 16,
    paddingVertical: 8,
    backgroundColor: '#fff',
    borderRadius: 16,
    borderWidth: 2,
    borderColor: '#edf2f7',
    marginRight: 8,
  },
  filterBtnActive: {
    backgroundColor: '#99e2a1',
    borderColor: '#99e2a1',
  },
  filterBtnText: {
    fontSize: 14,
    fontWeight: '600',
    color: '#4a5568',
  },
  filterBtnTextActive: {
    color: '#000',
  },
  categorySection: {
    marginBottom: 20,
  },
  categoryTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#2a2a2a',
    marginBottom: 12,
  },
  pictosGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 8,
  },
  picto: {
    width: '30%',
    alignItems: 'center',
    backgroundColor: '#fff',
    borderRadius: 8,
    padding: 8,
    borderWidth: 1,
    borderColor: '#f0f0f0',
  },
  pictoImage: {
    width: 50,
    height: 50,
    marginBottom: 4,
  },
  pictoLabel: {
    fontSize: 12,
    color: '#2a2a2a',
    textAlign: 'center',
    fontWeight: '500',
  },
  noResults: {
    alignItems: 'center',
    padding: 40,
  },
  noResultsEmoji: {
    fontSize: 48,
    marginBottom: 12,
  },
  noResultsText: {
    fontSize: 16,
    color: '#999',
    textAlign: 'center',
  },
  historySection: {
    backgroundColor: '#fff',
    borderRadius: 16,
    overflow: 'hidden',
    marginBottom: 20,
  },
  historyToggle: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    backgroundColor: '#e8f5e9',
    padding: 16,
  },
  historyTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#2D3436',
  },
  historyToggleIcon: {
    fontSize: 18,
  },
  historyContent: {
    borderTopWidth: 1,
    borderTopColor: '#e0e0e0',
  },
  historyHeader: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    padding: 8,
  },
  clearHistoryBtn: {
    padding: 8,
  },
  clearHistoryText: {
    color: '#e74c3c',
    fontSize: 14,
  },
  noHistory: {
    textAlign: 'center',
    padding: 20,
    color: '#7f8c8d',
    fontStyle: 'italic',
  },
  historyItem: {
    padding: 12,
    borderBottomWidth: 1,
    borderBottomColor: '#e0e0e0',
  },
  historyItemText: {
    fontSize: 16,
    color: '#2D3436',
  },
});
