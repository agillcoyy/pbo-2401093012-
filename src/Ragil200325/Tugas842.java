/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil200325;

/**
 *
 * @author Muhamad Soleh
 */
public class Tugas842 {
    public static void main(String[] args) {
        
        if (args.length != 2) {
            System.out.println("Gunakan: java ArithmeticOperation <bilangan1> <bilangan2>");
            return;
        }

        try {
            double bilangan1 = Double.parseDouble(args[0]);
            double bilangan2 = Double.parseDouble(args[1]);

            double hasilPenjumlahan = bilangan1 + bilangan2;
            double hasilPengurangan = bilangan1 - bilangan2;
            double hasilPerkalian = bilangan1 * bilangan2;

            if (bilangan2 == 0) {
                System.out.println("Pembagian dengan nol tidak diizinkan.");
            } else {
                double hasilPembagian = bilangan1 / bilangan2;
                System.out.println("Hasil Penjumlahan: " + hasilPenjumlahan);
                System.out.println("Hasil Pengurangan: " + hasilPengurangan);
                System.out.println("Hasil Perkalian: " + hasilPerkalian);
                System.out.println("Hasil Pembagian: " + hasilPembagian);
            }

        } catch (NumberFormatException e) {
            System.out.println("Argumen harus berupa bilangan.");
        }
    }
}
