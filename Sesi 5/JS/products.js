const products = [
  {
    id: 1,
    name: "ASUS Vivobook 15",
    description: "Color: Cool Silver, AMD Ryzen™ 3 7320U Processor 2.4GHz, LPDDR5 16GB, SSD 512GB M.2.",
    price: 8500000,
    category: "Laptop",
    image: "https://id.store.asus.com/media/catalog/product/v/i/vivobook_pro_15_oled_k6502z_product_photo_2s_cool_silver_05_1.jpg"
  },
  {
    id: 2,
    name: "Acer Aspire 5",
    description: 'ACER ASPIRE 5 A515-45-R49R [15.6"FHD/R5-5500U/8GB/512GB] BLACK (NX.A7ZSN.003)',
    price: 7800000,
    category: "Laptop",
    image: "https://tse3.mm.bing.net/th/id/OIP.kipfYgqQpn-8spj2ok7bmQHaD4?r=0&pid=Api&P=0&h=180"
  },
  {
    id: 3,
    name: "Lenovo IdeaPad Slim 3",
    description: 'Lenovo Ideapad Slim 3 14 Ryzen 3 7320U 8GB 512GB W11 + OHS 14" FHD.',
    price: 7200000,
    category: "Laptop",
    image: "https://tse4.mm.bing.net/th/id/OIP.nZKxnvR0nIXDfUbsJMocVgHaE3?r=0&pid=Api&P=0&h=180"
  },
  {
    id: 4,
    name: "MacBook Air M2",
    description: "13-inch MacBook Air: Apple M2 Chip with 8-core CPU, 8-core GPU, 16GB, 256GB, Starlight.",
    price: 18999000,
    category: "Laptop",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcBXYzAWzoIqZh-mri7CGCmoQDqiaNfx5zTPMLNXOcdw&s"
  },
  {
    id: 5,
    name: "HP Pavilion 14",
    description: "CPU, Intel® Core™ i7-1165G7. VGA, NVIDIA® GeForce® MX450. Display, 14″ Full HD IPS. RAM, 16 GB DDR4-3200 SDRAM.",
    price: 8900000,
    category: "Laptop",
    image: "https://tanphat.com.vn/media/product/3144_hp_pavilion_14.jpg"
  },

  {
    id: 6,
    name: "Samsung Galaxy S25",
    description: "12/256GB - Navy · 6.2 inch, FHD+ (1080 x 2340 pixels), Dynamic AMOLED 2X, 120Hz · Memori: RAM 12 GB, ROM 256 GB · CPU: Snapdragon 8 Elite.",
    price: 16999000,
    category: "Smartphone",
    image: "https://www.gizmochina.com/wp-content/uploads/2024/09/Samsung-Galaxy-S25-Render-Featured.png"
  },
  {
    id: 7,
    name: "iPhone 17",
    description: "Smartphone terbaru Apple.",
    price: 19999000,
    category: "Smartphone",
    image: "https://www.goimports.com.br/image/catalog/0%20novos%20produtos%202025/Iphones/iphone-17-storage-select-202509-black.png"
  },
  {
    id: 8,
    name: "Xiaomi 16 Pro",
    description: "Smartphone performa tinggi.",
    price: 8999000,
    category: "Smartphone",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTggSBr81oSwAEan01iMxeQ_hCEj0CHrQrBOuQfRKuL3Q&s=10"
  },
  {
    id: 9,
    name: "OPPO Reno 15",
    description: "Kamera jernih dan desain premium.",
    price: 6999000,
    category: "Smartphone",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPSt8cPCHQifnqe9-mzrpEIRDyT8eJ9Mji_qunkQ-lkw&s"
  },
  {
    id: 10,
    name: "Vivo V50",
    description: "Smartphone tipis dengan baterai besar.",
    price: 5499000,
    category: "Smartphone",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNU7hqYVeCSE_cTIQH8xgGzK-PbCS-VdCOoBmyxkORuQ&s=10"
  },

  {
    id: 11,
    name: "LG UltraGear 27",
    description: "27” UltraGear™ Monitor Game Full HD IPS 1 milisecond (GtG) NVIDIA® G-SYNC®.",
    price: 3980000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4KZHT1P_yJtvbwZv-2Fn85RvhgbEE7Cr7gLAqaQ2oPg&s=10"
  },
  {
    id: 12,
    name: "Samsung Odyssey G5",
    description: 'Samsung Odyssey G5 27" Curved Monitor Gaming QHD.',
    price: 4999000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK3UPQqMqboZoEof5GN1I7TQVUQPyaUjmxC0oBkDjesA&s=10"
  },
  {
    id: 13,
    name: "ASUS TUF VG249Q",
    description: "TUF Gaming VG249Q is a 23.8-inch, Full HD (1920x1080), IPS display with fast 144Hz refresh rate.",
    price: 2899000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlTGF-L5-e0KscKXZaZS4cu4iCoR5Y1P2wZUlI2cfHLg&s=10"
  },
  {
    id: 14,
    name: "Dell UltraSharp 24",
    description: '23.8" ⎚ Resolution / Refresh Rate Full HD (1080p) 1920 x 1080 at 120 Hz IPS  Adjustability Height, Tilt, Swivel, Pivot 🎨 Color Gamut.',
    price: 3199000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTiFiEdzXUo5qkZAhWx-xgtptrfnYZSbEq1ncLvnZiaSA&s=10"
  },
  {
    id: 15,
    name: "AOC 24G2",
    description: "Monitor Gaming IPS.",
    price: 2799000,
    category: "Monitor",
    image: "https://placehold.co/600x400?text=AOC+Monitor"
  },

  {
    id: 16,
    name: "Logitech G502 X",
    description: "Mouse Gaming RGB.",
    price: 899000,
    category: "Aksesoris",
    image: "https://placehold.co/600x400?text=G502+X"
  },
  {
    id: 17,
    name: "Razer DeathAdder V3",
    description: "Mouse esports ringan.",
    price: 1199000,
    category: "Aksesoris",
    image: "https://placehold.co/600x400?text=DeathAdder"
  },
  {
    id: 18,
    name: "SteelSeries Apex Pro",
    description: "Mechanical Keyboard.",
    price: 2899000,
    category: "Aksesoris",
    image: "https://placehold.co/600x400?text=Apex+Pro",
    keywords: ["keyboard", "mechanical", "gaming", "rgb", "steelseries"]
  },
  {
    id: 19,
    name: "HyperX Cloud III",
    description: "Gaming Headset.",
    price: 1599000,
    category: "Aksesoris",
    image: "https://placehold.co/600x400?text=Cloud+III"
  },
  {
    id: 20,
    name: "Xbox Wireless Controller",
    description: "Controller resmi Xbox.",
    price: 999000,
    category: "Aksesoris",
    image: "https://placehold.co/600x400?text=Xbox+Controller"
  }
];

// Menambahkan produk otomatis hingga berjumlah 50
const categories = ["Laptop", "Smartphone", "Monitor", "Aksesoris"];

for (let i = 21; i <= 50; i++) {
  const category = categories[(i - 1) % categories.length];

  products.push({
    id: i,
    name: `${category} Premium ${i}`,
    description: `Produk ${category} berkualitas tinggi nomor ${i}.`,
    price: Math.floor(Math.random() * 18000000) + 300000,
    category: category,
    image: `https://placehold.co/600x400?text=${encodeURIComponent(category + " " + i)}`
  });
}
