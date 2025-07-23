/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil180325;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import javax.swing.JOptionPane;

/**
 *
 * @author Muhamad Soleh
 */
public class Tugas772 {
    public static void main(String[] args) {
        try {
            BufferedReader reader = new BufferedReader(new InputStreamReader(System.in));
            int[] numbers = new int[10];
            int largest = Integer.MIN_VALUE;

            // Meminta 10 input
            for (int i = 0; i < 10; i++) {
                String input = JOptionPane.showInputDialog(null, "Masukkan angka ke-" + (i + 1) + ":", "Input Angka", JOptionPane.QUESTION_MESSAGE);
                if (input != null) {
                    numbers[i] = Integer.parseInt(input);
                    // Menentukan angka terbesar
                    if (numbers[i] > largest) {
                        largest = numbers[i];
                    }
                } else {
                    JOptionPane.showMessageDialog(null, "Input dibatalkan.");
                    return;
                }
            }

            // Menampilkan angka terbesar
            JOptionPane.showMessageDialog(null, "Angka terbesar yang Anda masukkan adalah: " + largest, "Hasil", JOptionPane.INFORMATION_MESSAGE);

        } catch (Exception e) {
            JOptionPane.showMessageDialog(null, "Terjadi kesalahan: " + e.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
        }
    }
}
