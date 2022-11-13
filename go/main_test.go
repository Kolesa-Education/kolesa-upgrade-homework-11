package main

import (
	"github.com/stretchr/testify/require"
	"testing"

	"github.com/kulti/titlecase"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	msg := "TitleCase(" + str + ", " + minor + ") = " + got + "; want " + want
	require.Equal(t, got, want, msg)
}

func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента
	t.Error("not implemented")
	const str, minor, want = "teenage mutant ninja turtles", "teenage", "Teenage Mutant Ninja Turtles"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		// передайте пустую строку в качестве второго агрумента
		msg := "TitleCase(" + str + ", " + minor + ") = " + got + "; want " + want
		require.Equal(t, got, want, msg)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента
	t.Error("not implemented")
	const str, minor, want = "the quick fox in the bag", "the", "the quick fox in the bag"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		// передайте первое слово исходной строки в качестве второго аргумента
		msg := "TitleCase(" + str + ", " + minor + ") = " + got + "; want " + want
		require.Equal(t, got, want, msg)
	}
}
func TestWithEmptyStr(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	msg := "TitleCase(" + str + ", " + minor + ") = " + got + "; want " + want
	require.Equal(t, got, want, msg)
}
