const products = [
  {
    id: 1,
    name: "ASUS Vivobook 15",
    description: "Color: Cool Silver, AMD Ryzen™ 3 7320U Processor 2.4GHz, LPDDR5 16GB, SSD 512GB M.2.",
    price: 11199000,
    category: "Laptop",
    image: "https://id.store.asus.com/media/catalog/product/v/i/vivobook_pro_15_oled_k6502z_product_photo_2s_cool_silver_05_1.jpg",
    keywords: ["laptop", "AMD Ryzen 3", "asus", "vivobook", "ssd 512 GB"]
  },
  {
    id: 2,
    name: "Acer Aspire 5",
    description: 'ACER ASPIRE 5 A515-45-R49R [15.6"FHD/R5-5500U/8GB/512GB] BLACK (NX.A7ZSN.003)',
    price: 7800000,
    category: "Laptop",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJZRGfvK610qVb6o5Dp24lcVbSGq43b-wgTYrLSg8H5g&s=10",
    keywords: ["laptop", "AMD Ryzen 5", "acer", "aspire", "8/512"]
  },
  {
    id: 3,
    name: "Lenovo IdeaPad Slim 3",
    description: 'LENOVO IDEAPAD SLIM 3 14 I5 13420H 8GB 512GB W11+OHS+M365B 14.0WUXGA IPS BLIT 2Y PREM+2ADP BLU -7DID.',
    price: 9900000,
    category: "Laptop",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZx5V5dzDgSea4XVrWBOcKDAdbdOhp7z2j1CchbN4nYQ&s=10",
    keywords: ["laptop", "Intel Core i5", "lenovo", "ideapad slim", "8/512"]
  },
  {
    id: 4,
    name: "MacBook Air M2",
    description: "13-inch MacBook Air: Apple M2 Chip with 8-core CPU, 8-core GPU, 16GB, 256GB, Starlight.",
    price: 18999000,
    category: "Laptop",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTcBXYzAWzoIqZh-mri7CGCmoQDqiaNfx5zTPMLNXOcdw&s",
    keywords: ["laptop", "Apple M2", "Macbook", "Air M2", "16/256"]
  },
  {
    id: 5,
    name: "HP Pavilion 14",
    description: "CPU, Intel® Core™ i7-1165G7. VGA, NVIDIA® GeForce® MX450. Display, 14″ Full HD IPS. RAM, 16 GB DDR4-3200 SDRAM.",
    price: 8900000,
    category: "Laptop",
    image: "https://tanphat.com.vn/media/product/3144_hp_pavilion_14.jpg",
    keywords: ["laptop", "Intel Core i7", "HP", "pavilion", "nvidia mx450"]
  },

  {
    id: 6,
    name: "Samsung Galaxy S25",
    description: "12/256GB - Navy · 6.2 inch, FHD+ (1080 x 2340 pixels), Dynamic AMOLED 2X, 120Hz · Memori: RAM 12 GB, ROM 256 GB · CPU: Snapdragon 8 Elite.",
    price: 16999000,
    category: "Smartphone",
    image: "https://www.gizmochina.com/wp-content/uploads/2024/09/Samsung-Galaxy-S25-Render-Featured.png",
    keywords: ["Samsung", "S25", "HP", "Snapdragon 8 Elite", "AMOLED", "Flagship"]
  },
  {
    id: 7,
    name: "iPhone 17",
    description: "iOS 26. Processor: Apple A19 Chip, 6-core CPU, 16-core Neural Engine, 6.3 Inch, Super Retina XDR, 48 MP Fusion Wide ƒ/1.6 with sensor-shift OIS, 100% Focus Pixels.",
    price: 17999000,
    category: "Smartphone",
    image: "https://www.goimports.com.br/image/catalog/0%20novos%20produtos%202025/Iphones/iphone-17-storage-select-202509-black.png",
    keywords: ["iPhone", "17", "HP", "Apple A19", "Flagship"]
  },
  {
    id: 8,
    name: "Xiaomi 15T Pro",
    description: "Xiaomi 15T Pro 5G Android smartphone. Features 6.83″ display, Dimensity 9400+ chipset, 5500 mAh battery, 1024 GB storage, 12 GB RAM.",
    price: 10599000,
    category: "Smartphone",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZPSVkQX-qTXCOURivEs7hT3LPINtpGfISZPvFEEimbw&s=10",
    keywords: ["Xiaomi", "15T Pro", "HP", "Dimensity 9400+", "1TB", "Flagship"]
  },
  {
    id: 9,
    name: "OPPO Reno 15",
    description: "OLED Full HD+ display with Refresh Rate 120 Hz.Selfie Camera Ultra Wide 50 MP. Snapdragon 7 Gen 4 and 6500 mAh battery.",
    price: 6999000,
    category: "Smartphone",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPSt8cPCHQifnqe9-mzrpEIRDyT8eJ9Mji_qunkQ-lkw&s",
    keywords: ["OPPO", "Reno 15", "HP", "Snapdragon 7 Gen 4", "AMOLED"]
  },
  {
    id: 10,
    name: "Vivo V50",
    description: " Features 6.77″ display, Snapdragon 7 Gen 3 chipset, 6000 mAh battery, 512 GB storage, 12 GB RAM, ZEISS 50 MP Potrait So Pro.",
    price: 6499000,
    category: "Smartphone",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNU7hqYVeCSE_cTIQH8xgGzK-PbCS-VdCOoBmyxkORuQ&s=10",
    keywords: ["Samsung", "S25", "HP", "Snapdragon 7 Gen 3", "Zeiss"]
  },

  {
    id: 11,
    name: "LG UltraGear 27",
    description: "27” UltraGear™ Monitor Game Full HD IPS 1 milisecond (GtG) NVIDIA® G-SYNC®.",
    price: 3980000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4KZHT1P_yJtvbwZv-2Fn85RvhgbEE7Cr7gLAqaQ2oPg&s=10",
    keywords: ["Monitor", '27"', "LG", "Ultragear", "Full HD IPS", "NVIDIA G-SYNC"]
  },
  {
    id: 12,
    name: "Samsung Odyssey G5",
    description: 'Samsung Odyssey G5 27" Curved Monitor Gaming QHD, high refresh rate up to 165Hz–200Hz, and time respons 1ms (MPRT).',
    price: 4999000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQK3UPQqMqboZoEof5GN1I7TQVUQPyaUjmxC0oBkDjesA&s=10",
    keywords: ["Monitor", '27"', "Samsung", "Odyssey G5", "Full HD IPS", "NVIDIA G-SYNC"]
  },
  {
    id: 13,
    name: "ASUS TUF VG249Q",
    description: "TUF Gaming VG249Q is a 23.8-inch, Full HD (1920x1080), IPS display with fast 144Hz refresh rate.",
    price: 2899000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlTGF-L5-e0KscKXZaZS4cu4iCoR5Y1P2wZUlI2cfHLg&s=10",
    keywords: ["Monitor", '23"', "Asus", "TUF VG249Q", "Full HD IPS", "NVIDIA G-SYNC"]
  },
  {
    id: 14,
    name: "Dell UltraSharp 24",
    description: '23.8" ⎚ Resolution / Refresh Rate Full HD (1080p) 1920 x 1080 at 120 Hz IPS  Adjustability Height, Tilt, Swivel, Pivot 🎨 Color Gamut.',
    price: 3199000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTiFiEdzXUo5qkZAhWx-xgtptrfnYZSbEq1ncLvnZiaSA&s=10",
    keywords: ["Monitor", '23"', "Dell", "Ultrasharp 24", "Full HD IPS"]
  },
  {
    id: 15,
    name: "AOC 24G2",
    description: "AOC’s 24G2 flat display redefines smooth gameplay. Equipped with 144Hz refresh rate and 1ms response time.",
    price: 2799000,
    category: "Monitor",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9KfVxKLDxd0RXPAAlsS8tS1W_m1krGFdSDCB5UOKGaQ&s=10",
    keywords: ["Monitor", '144Hz', "AOC", "24G2"]
  },

  {
    id: 16,
    name: "Logitech G502 X Plus",
    description: "Shop G502 X Plus Mouse. Features LIGHTFORCE hybrid optical-mechanical switch technology, power-saving play detection, 68% faster response, and 8-LED RGB.",
    price: 2500000,
    category: "Aksesoris",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhcLMrOGEZ_XR7A1-t4mH4cumzkYqvkNsrBsuEVS4rSQ&s=10",
    keywords: ["Mouse", "Logitech", "G502 X Plus", "Optical", "Lightforce", "Gaming"]
  },
  {
    id: 17,
    name: "Razer DeathAdder V3",
    description: "Victory takes on a new shape with the Razer DeathAdder V3 - an ergonomic esports gaming mouse with a true 8000 Hz polling rate for the fastest response.",
    price: 1199000,
    category: "Aksesoris",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTem2Zna4WlwOT0w82bUstfkuoQYHcNvBHutx7-yAe1tA&s=10",
    keywords: ["Mouse", "Razer", "DeathADDER V3", "Ergonomic esport", "Gaming"]
  },
  {
    id: 18,
    name: "SteelSeries Apex Pro",
    description: "Steelseries Apex Pro TKL Wireless Gen 3 Rapid Tap SOCD - OmniPoint 3.0 Switch Gaming Keyboard.",
    price: 2899000,
    category: "Aksesoris",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQundjiExKuIDNKhR51bXuTqZmBD4k-kAAnxxzRi7B_jA&s=10",
    keywords: ["Keyboard", "Mechanical", "Gaming", "RGB", "Steelseries"]
  },
  {
    id: 19,
    name: "HyperX Cloud III",
    description: "Discover the HyperX Cloud III wired/wireless gaming headset and learn more about legendary comfort, high quality audio, and more. A legend reborn. Shop now!",
    price: 1599000,
    category: "Aksesoris",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkhqCu_LUPvzDJjqWPihve2YWBstw9Zxuua0P_hcsTjA&s=10",
    keywords: ["Headset", "HyperX", "Cloud III", "Gaming", "RGB"]
  },
  {
    id: 20,
    name: "Xbox Wireless Controller",
    description: "Connect to XBOX consoles with XBOX Wireless. Stay on target with textured grip and a hybrid D-pad.",
    price: 999000,
    category: "Aksesoris",
    image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9UPp1nwj6ZnfAGmCwaForRQC10JpYSu-EnYE8_0UQAA&s=10",
    keywords: ["Controller", "Wireless", "Gaming", "RGB", "Hybird D-PAD"]
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
