/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil130325;

import javax.swing.JOptionPane;

/**
 *
 * @author Muhamad Soleh
 */
public class Tugas651JOptionPane {
    

    public static void main(String[] args) {
        String input1 = JOptionPane.showInputDialog("Masukkan nilai ujian pertama:");
        String input2 = JOptionPane.showInputDialog("Masukkan nilai ujian kedua:");
        String input3 = JOptionPane.showInputDialog("Masukkan nilai ujian ketiga:");

        int nilai1 = Integer.parseInt(input1);
        int nilai2 = Integer.parseInt(input2);
        int nilai3 = Integer.parseInt(input3);

        int rataRata = (nilai1 + nilai2 + nilai3) / 3;

        String output = "Nilai rata-rata: " + rataRata + "\n";
        if (rataRata >= 60) {
            output += ":)";
        } else {
            output += ":-(";
        }

        JOptionPane.showMessageDialog(null, output);
    }
}
