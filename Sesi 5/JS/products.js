const products = [
  {
    id: 1,
    name: "ASUS Vivobook 15",
    description: "Laptop Intel Core i5 Gen 13, RAM 16GB, SSD 512GB.",
    price: 8500000,
    category: "Laptop",
    image: "https://placehold.co/600x400?text=ASUS+Vivobook"
  },
  {
    id: 2,
    name: "Acer Aspire 5",
    description: "Laptop Ryzen 5 dengan SSD 512GB.",
    price: 7800000,
    category: "Laptop",
    image: "https://placehold.co/600x400?text=Acer+Aspire"
  },
  {
    id: 3,
    name: "Lenovo IdeaPad Slim 3",
    description: "Laptop ringan untuk belajar dan bekerja.",
    price: 7200000,
    category: "Laptop",
    image: "https://placehold.co/600x400?text=IdeaPad+Slim"
  },
  {
    id: 4,
    name: "MacBook Air M2",
    description: "Laptop Apple dengan chip M2.",
    price: 18999000,
    category: "Laptop",
    image: "https://placehold.co/600x400?text=MacBook+Air"
  },
  {
    id: 5,
    name: "HP Pavilion 14",
    description: "Laptop elegan untuk produktivitas.",
    price: 8900000,
    category: "Laptop",
    image: "https://placehold.co/600x400?text=HP+Pavilion"
  },

  {
    id: 6,
    name: "Samsung Galaxy S25",
    description: "Smartphone flagship Samsung.",
    price: 16999000,
    category: "Smartphone",
    image: "https://placehold.co/600x400?text=Galaxy+S25"
  },
  {
    id: 7,
    name: "iPhone 17",
    description: "Smartphone terbaru Apple.",
    price: 19999000,
    category: "Smartphone",
    image: "https://placehold.co/600x400?text=iPhone+17"
  },
  {
    id: 8,
    name: "Xiaomi 16 Pro",
    description: "Smartphone performa tinggi.",
    price: 8999000,
    category: "Smartphone",
    image: "https://placehold.co/600x400?text=Xiaomi+16"
  },
  {
    id: 9,
    name: "OPPO Reno 15",
    description: "Kamera jernih dan desain premium.",
    price: 6999000,
    category: "Smartphone",
    image: "https://placehold.co/600x400?text=OPPO+Reno"
  },
  {
    id: 10,
    name: "vivo V50",
    description: "Smartphone tipis dengan baterai besar.",
    price: 5499000,
    category: "Smartphone",
    image: "https://placehold.co/600x400?text=vivo+V50"
  },

  {
    id: 11,
    name: "LG UltraGear 27",
    description: "Monitor Gaming 165Hz.",
    price: 3999000,
    category: "Monitor",
    image: "https://placehold.co/600x400?text=LG+Monitor"
  },
  {
    id: 12,
    name: "Samsung Odyssey G5",
    description: "Monitor Gaming QHD.",
    price: 4999000,
    category: "Monitor",
    image: "https://placehold.co/600x400?text=Odyssey+G5"
  },
  {
    id: 13,
    name: "ASUS TUF VG249Q",
    description: "Monitor IPS 144Hz.",
    price: 2899000,
    category: "Monitor",
    image: "https://placehold.co/600x400?text=ASUS+Monitor"
  },
  {
    id: 14,
    name: "Dell UltraSharp 24",
    description: "Monitor profesional Full HD.",
    price: 3199000,
    category: "Monitor",
    image: "https://placehold.co/600x400?text=Dell+Monitor"
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
    category: "Gaming",
    image: "https://placehold.co/600x400?text=G502+X"
  },
  {
    id: 17,
    name: "Razer DeathAdder V3",
    description: "Mouse esports ringan.",
    price: 1199000,
    category: "Gaming",
    image: "https://placehold.co/600x400?text=DeathAdder"
  },
  {
    id: 18,
    name: "SteelSeries Apex Pro",
    description: "Mechanical Keyboard.",
    price: 2899000,
    category: "Gaming",
    image: "https://placehold.co/600x400?text=Apex+Pro"
  },
  {
    id: 19,
    name: "HyperX Cloud III",
    description: "Gaming Headset.",
    price: 1599000,
    category: "Gaming",
    image: "https://placehold.co/600x400?text=Cloud+III"
  },
  {
    id: 20,
    name: "Xbox Wireless Controller",
    description: "Controller resmi Xbox.",
    price: 999000,
    category: "Gaming",
    image: "https://placehold.co/600x400?text=Xbox+Controller"
  }
];

// Menambahkan produk otomatis hingga berjumlah 50
const categories = ["Laptop", "Smartphone", "Monitor", "Gaming"];

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

console.log(products);
